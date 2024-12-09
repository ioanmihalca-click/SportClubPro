<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PostResource\Pages\Actions\GenerateArticleAction;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;


    

    protected function getHeaderActions(): array
    {
        return [
            GenerateArticleAction::make('generateArticle'),
        ];
    }
}
