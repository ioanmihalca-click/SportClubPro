<?php

namespace App\Filament\Resources\PostResource\Pages\Actions;

use Exception;
use App\Models\Post;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Category;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\QueryException;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use App\Services\Blog\GrokArticleGenerationService;
use Filament\Forms\Components\Actions\Action as FormAction;



class GenerateArticleAction extends Action
{


    private function withDatabaseReconnection(callable $callback)
    {
        $maxAttempts = 3;
        $attempt = 1;
    
        while ($attempt <= $maxAttempts) {
            try {
                if (!DB::connection()->getPdo()) {
                    DB::reconnect();
                }
                return $callback();
            } catch (QueryException $e) {
                if ($attempt === $maxAttempts || !$this->isConnectionError($e)) {
                    throw $e;
                }
                
                Log::warning("Database connection attempt {$attempt} failed, retrying...");
                DB::reconnect();
                sleep(1);
                $attempt++;
            }
        }
    }
    
    private function isConnectionError(QueryException $e): bool
    {
        return $e->getCode() == 2006 || 
               str_contains($e->getMessage(), 'server has gone away') ||
               str_contains($e->getMessage(), 'Lost connection');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Generează Articol')
            ->icon('heroicon-o-sparkles')
            ->color('primary')
            ->form([
                Select::make('category')
                    ->label('Categorie')
                    ->options(Category::pluck('name', 'id'))
                    ->required()
                    ->live(),

                Select::make('template')
                    ->label('Tip Articol')
                    ->options(function (Get $get) {
                        $category = $get('category');
                        $options = self::getTemplateOptions($category);
                        Log::info('Template select options:', ['options' => $options]);
                        return $options;
                    })
                    ->required()
                    ->disabled(fn(Get $get) => !$get('category'))
                    ->visible(fn(Get $get) => !empty($get('category'))),

                Section::make('Conținut')
                    ->schema([
                        TextInput::make('topic')
                            ->label('Subiect Specific')
                            ->required()
                            ->maxLength(100),
                    ])
                    ->headerActions([
                        FormAction::make('generateTopic')
                            ->label('Generează Subiect')
                            ->icon('heroicon-m-sparkles')
                            ->color('primary')
                            ->action(function (Set $set, Get $get) {
                                try {
                                    $service = app(GrokArticleGenerationService::class);
                                    $categorySlug = $this->getSlugForCategory((int)$get('category'));

                                    $result = $service->generateTopicSuggestion(
                                        $categorySlug,
                                        $get('template')
                                    );

                                    if ($result['success']) {
                                        $set('topic', $result['topic']);
                                        Notification::make()
                                            ->success()
                                            ->title('Sugestie generată')
                                            ->send();
                                    } else {
                                        Notification::make()
                                            ->danger()
                                            ->title('Eroare la generarea sugestiei')
                                            ->body($result['error'])
                                            ->send();
                                    }
                                } catch (\Exception $e) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Eroare')
                                        ->body('Nu s-a putut genera o sugestie')
                                        ->send();
                                }
                            })
                    ]),

                Section::make('Imagine')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Imagine principală')
                            ->image()
                            ->directory('blog-images'),
                    ])
                    ->headerActions([
                        FormAction::make('generateImage')
                            ->label('Generează Imagine')
                            ->icon('heroicon-m-photo')
                            ->color('primary')
                            ->action(function (Set $set, Get $get) {
                                try {
                                    $service = app(GrokArticleGenerationService::class);
                                    $categorySlug = $this->getSlugForCategory((int)$get('category'));

                                    $promptResult = $service->generateImagePrompt(
                                        $categorySlug,
                                        $get('template'),
                                        $get('topic')
                                    );

                                    if (!$promptResult['success']) {
                                        throw new Exception('Nu s-a putut genera prompt-ul pentru imagine');
                                    }

                                    $imageResult = $service->generateImage($promptResult['prompt']);

                                    if ($imageResult['success']) {
                                        // Setăm ca array pentru a face Filament fericit
                                        $set('featured_image', [$imageResult['url']]);
                                        Notification::make()
                                            ->success()
                                            ->title('Imagine generată')
                                            ->send();
                                    } else {
                                        throw new Exception($imageResult['error']);
                                    }
                                } catch (\Exception $e) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Eroare')
                                        ->body('Nu s-a putut genera imaginea')
                                        ->send();
                                }
                            })
                    ])
            ])
            ->action(function (array $data, GrokArticleGenerationService $service) {
                return $this->withDatabaseReconnection(function () use ($data, $service) {
                    try {
                        DB::beginTransaction();
            
                        $category = Category::findOrFail($data['category']);
                        $categorySlug = $this->getSlugForCategory((int)$data['category']);
            
                        $result = $service->generateArticle(
                            $categorySlug,
                            $data['template'],
                            $data['topic']
                        );
            
                        if (!$result['success']) {
                            DB::rollBack();
                            Notification::make()
                                ->danger()
                                ->title('Eroare')
                                ->body('Generarea articolului a eșuat: ' . ($result['error'] ?? 'Eroare necunoscută'))
                                ->send();
                            return;
                        }
            
                        $validatedData = $this->validateGeneratedContent($result);
            
                        $post = Post::create([
                            'title' => $validatedData['title'],
                            'slug' => $this->generateUniqueSlug($validatedData['title']),
                            'content' => $validatedData['content'],
                            'meta_description' => $validatedData['meta_description'],
                            'status' => 'draft',
                            'category_id' => $data['category'],
                            'featured_image' => $data['featured_image'] ?? null,
                            'generated_at' => now(),
                        ]);
            
                        DB::commit();
            
                        Notification::make()
                            ->success()
                            ->title('Succes')
                            ->body('Articolul a fost generat și salvat cu succes!')
                            ->send();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error('Eroare la generarea articolului: ' . $e->getMessage());
                        
                        Notification::make()
                            ->danger()
                            ->title('Eroare')
                            ->body('A apărut o eroare la salvarea articolului.')
                            ->send();
                    }
                });
            });
    }


    private function validateGeneratedContent(array $result): array
    {
        return validator($result, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_description' => 'required|string|max:160',
        ])->validate();
    }

    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = Str::slug($title) . '-' . $count++;
        }

        return $slug;
    }

    private function getSlugForCategory(int $categoryId): string
    {
        $categoryMap = [
            1 => 'management',
            2 => 'marketing',
            3 => 'finance',
            4 => 'technology',
            5 => 'youth_development',
            6 => 'coaching',
            7 => 'case_studies',
            8 => 'events',
            9 => 'legal',
            10 => 'health'
        ];

        return $categoryMap[$categoryId] ?? throw new \Exception("Categorie invalidă");
    }


    private static function getTemplateOptions($category): array
    {
        if (!$category) {
            return [];
        }

        // Obține categoria din baza de date
        $categoryModel = Category::find($category);
        if (!$categoryModel) {
            return [];
        }

        // Mapare între slug-urile din DB și cheile din template-uri
        $slugMap = [
            'management-si-organizare' => 'management',
            'marketing-pentru-cluburi-sportive' => 'marketing',     // updated
            'aspecte-financiare-si-bugetare' => 'finance',         // updated
            'tehnologie-in-sport' => 'technology',
            'dezvoltarea-tinerilor-sportivi' => 'youth_development', // updated
            'best-practices-in-coaching' => 'coaching',
            'studii-de-caz-si-success-stories' => 'case_studies',  // updated
            'evenimente-si-competitii' => 'events',
            'legislatie-si-aspecte-juridice' => 'legal',
            'sanatate-si-nutritie-sportiva' => 'health'
        ];


        // Convertește slug-ul din DB în cheia pentru template-uri
        $templateKey = $slugMap[$categoryModel->slug] ?? $categoryModel->slug;

        Log::info('Category slug check:', [
            'db_slug' => $categoryModel->slug,
            'mapped_slug' => $slugMap[$categoryModel->slug] ?? 'not_found',
            'has_templates' => isset($templates[$templateKey])
        ]);


        $templates = [
            'management' => [
                'how_to' => 'Ghid Pas cu Pas',
                'guide' => 'Ghid Complet',
                'analysis' => 'Analiză',
            ],
            'marketing' => [
                'how_to' => 'Ghid Practic',
                'strategy' => 'Strategie',
                'trends' => 'Tendințe',
            ],
            'finance' => [
                'how_to' => 'Ghid de Management Financiar',
                'analysis' => 'Analiză Financiară',
                'planning' => 'Planificare Financiară',
            ],
            'technology' => [
                'guide' => 'Ghid Tehnologic',
                'trends' => 'Tendințe Tehnologice',
                'implementation' => 'Implementare Tehnologică',
            ],
            'youth_development' => [
                'guide' => 'Ghid pentru Dezvoltarea Juniorilor',
                'best_practices' => 'Cele Mai Bune Practici',
                'program' => 'Program de Dezvoltare',
            ],
            'coaching' => [
                'guide' => 'Ghidul Antrenorului',
                'techniques' => 'Tehnici de Coaching',
                'best_practices' => 'Cele Mai Bune Practici',
            ],
            'case_studies' => [
                'success_story' => 'Poveste de Succes',
                'analysis' => 'Analiză de Caz',
                'implementation' => 'Implementare Practică',
            ],
            'events' => [
                'planning' => 'Planificare Evenimente',
                'management' => 'Management de Evenimente',
                'best_practices' => 'Cele Mai Bune Practici',
            ],
            'legal' => [
                'guide' => 'Ghid de Aspecte Legale',
                'compliance' => 'Conformitate',
                'regulations' => 'Reglementări',
            ],
            'health' => [
                'guide' => 'Ghid pentru Sănătate',
                'best_practices' => 'Cele Mai Bune Practici',
                'recommendations' => 'Recomandări',
            ],
        ];

        $options = $templates[$templateKey] ?? [];

        Log::info('Template options final:', [
            'template_key' => $templateKey,
            'options' => $options
        ]);

        return $options;
    }
}
