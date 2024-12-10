<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PostResource\Pages\Actions\GenerateArticleAction;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Adăugare Articol'),
            GenerateArticleAction::make('generateArticle')
                ->label('Generează Articol')
                ->color('primary'),
        ];
    }
}
