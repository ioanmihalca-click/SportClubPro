<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Articol';
    protected static ?string $pluralModelLabel = 'Articole';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make('Informații principale')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Titlu')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => 
                                        $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Post::class, 'slug', ignoreRecord: true),

                                Forms\Components\Select::make('category_id')
                                    ->label('Categorie')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('Imagine principală')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('blog-images')
                                    ->columnSpanFull(),

                                Forms\Components\RichEditor::make('content')
                                    ->label('Conținut')
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'orderedList',
                                        'unorderedList',
                                        'h2',
                                        'h3',
                                        'blockquote',
                                        'redo',
                                        'undo',
                                        'code'
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpan(['lg' => 2]),

                        Forms\Components\Section::make('Publicare și SEO')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'draft' => 'Ciornă',
                                        'published' => 'Publicat',
                                    ])
                                    ->default('draft')
                                    ->required(),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Data publicării')
                                    ->nullable(),

                                Forms\Components\Textarea::make('meta_description')
                                    ->label('Meta descriere')
                                    ->maxLength(160)
                                    ->helperText('Descriere scurtă pentru SEO, maxim 160 caractere')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(['lg' => 1])
                    ])
                    ->columns(['lg' => 3])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Imagine')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Titlu')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categorie')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'published' => 'Publicat',
                        'draft' => 'Ciornă',
                    }),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Data publicării')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Vizualizări')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'published' => 'Publicat',
                        'draft' => 'Ciornă',
                    ]),

                Tables\Filters\SelectFilter::make('category')
                    ->label('Categorie')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}