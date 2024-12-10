<?php

namespace App\Filament\Resources\PostResource\Pages\Actions;

use App\Models\Post;
use Filament\Forms\Get;
use App\Models\Category;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Services\Blog\GrokArticleGenerationService;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Set;
use Filament\Notifications\Notification;

class GenerateArticleAction extends Action
{
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

            
                    
                    TextInput::make('topic')
                    ->label('Subiect Specific')
                    ->required()
                    ->maxLength(100)
                    ->suffixAction(
                        FormAction::make('generateTopic')
                            ->icon('heroicon-m-sparkles')
                            ->color('primary')
                            ->action(function (Set $set, Get $get, GrokArticleGenerationService $service) {
                                try {
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
                                            ->error()
                                            ->title('Eroare la generarea sugestiei')
                                            ->body($result['error'])
                                            ->send();
                                    }
                                } catch (\Exception $e) {
                                    Notification::make()
                                        ->error()
                                        ->title('Eroare')
                                        ->body('Nu s-a putut genera o sugestie')
                                        ->send();
                                }
                            })
                    ),
            ])
            ->action(function (array $data, GrokArticleGenerationService $service) {
                try {
                    DB::beginTransaction();

                    // Obținem categoria din baza de date
                    $category = Category::findOrFail($data['category']);

                    // Folosim maparea pentru a obține slug-ul corect pentru service
                    $slugMap = [
                        'management-si-organizare' => 'management',
                        'marketing-pentru-cluburi' => 'marketing',
                        'aspecte-financiare' => 'finance',
                        'tehnologie-in-sport' => 'technology',
                        'dezvoltarea-tinerilor' => 'youth-development',
                        'best-practices-in-coaching' => 'coaching',
                        'studii-de-caz' => 'case-studies',
                        'evenimente-si-competitii' => 'events',
                        'legislatie-si-aspecte-juridice' => 'legal',
                        'sanatate-si-nutritie-sportiva' => 'health'
                    ];

                    $categorySlug = $slugMap[$category->slug] ?? $category->slug;

                    // Generează articolul folosind slug-ul categoriei
                    $result = $service->generateArticle(
                        $categorySlug, // trimitem slug-ul în loc de ID
                        $data['template'],
                        $data['topic']
                    );

                    if (!$result['success']) {
                        DB::rollBack();
                        $this->failure(
                            'Generarea articolului a eșuat: ' .
                                ($result['error'] ?? 'Eroare necunoscută')
                        );
                        return;
                    }

                    // Validează datele primite
                    $validatedData = $this->validateGeneratedContent($result);

                    // Creează articolul folosind ID-ul original al categoriei
                    $post = Post::create([
                        'title' => $validatedData['title'],
                        'slug' => $this->generateUniqueSlug($validatedData['title']),
                        'content' => $validatedData['content'],
                        'meta_description' => $validatedData['meta_description'],
                        'status' => 'draft',
                        'category_id' => $data['category'], // folosim ID-ul original
                        'generated_at' => now(),
                    ]);

                    DB::commit();

                    $this->success('Articolul a fost generat și salvat cu succes!');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Eroare la generarea articolului: ' . $e->getMessage());
                    $this->failure('A apărut o eroare la salvarea articolului.');
                }
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
            'marketing-pentru-cluburi' => 'marketing',
            'aspecte-financiare' => 'finance',
            'tehnologie-in-sport' => 'technology',
            'dezvoltarea-tinerilor' => 'youth-development',
            'best-practices-in-coaching' => 'coaching',
            'studii-de-caz' => 'case-studies',
            'evenimente-si-competitii' => 'events',
            'legislatie-si-aspecte-juridice' => 'legal',
            'sanatate-si-nutritie-sportiva' => 'health'
        ];

        // Convertește slug-ul din DB în cheia pentru template-uri
        $templateKey = $slugMap[$categoryModel->slug] ?? $categoryModel->slug;

        Log::info('Template options:', [
            'category_id' => $category,
            'db_slug' => $categoryModel->slug,
            'template_key' => $templateKey
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
            'youth-development' => [
                'guide' => 'Ghid pentru Dezvoltarea Juniorilor',
                'best_practices' => 'Cele Mai Bune Practici',
                'program' => 'Program de Dezvoltare',
            ],
            'coaching' => [
                'guide' => 'Ghidul Antrenorului',
                'techniques' => 'Tehnici de Coaching',
                'best_practices' => 'Cele Mai Bune Practici',
            ],
            'case-studies' => [
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
