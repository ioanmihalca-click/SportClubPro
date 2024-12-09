<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PopularPosts extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';
    
    protected function getStats(): array
    {
        // Luăm top 4 articole după vizualizări
        $popularPosts = Post::query()
            ->published()
            ->with('category')
            ->orderByDesc('views_count')
            ->limit(4)
            ->get();

        return $popularPosts->map(function ($post) {
            return Stat::make(
                label: $post->title,
                value: number_format($post->views_count) . ' vizualizări'
            )
                ->description($post->category->name)
                ->descriptionIcon('heroicon-m-eye')
                ->color('success')
                ->chart([
                    $post->views_count * 0.2,
                    $post->views_count * 0.4,
                    $post->views_count * 0.6,
                    $post->views_count * 0.8,
                    $post->views_count
                ])
                ->url(route('blog.post', $post->slug))
                ->openUrlInNewTab();
        })->toArray();
    }
}