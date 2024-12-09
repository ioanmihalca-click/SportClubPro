<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class BlogStats extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';
    
    protected function getStats(): array
    {
        $totalPosts = Post::count();
        $publishedPosts = Post::published()->count();
        $totalCategories = Category::count();
        $totalViews = Post::sum('views_count');
        
        $postsThisMonth = Post::where('created_at', '>=', now()->startOfMonth())->count();
        $viewsThisMonth = Post::where('created_at', '>=', now()->startOfMonth())->sum('views_count');

        return [
            Stat::make('Total Articole', $totalPosts)
                ->description($publishedPosts . ' publicate')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Categorii', $totalCategories)
                ->description('Categorii active')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('success'),

            Stat::make('Total Vizualizări', number_format($totalViews))
                ->description(number_format($viewsThisMonth) . ' luna aceasta')
                ->descriptionIcon('heroicon-m-eye')
                ->color('warning'),

            Stat::make('Articole Luna Aceasta', $postsThisMonth)
                ->description('Articole noi')
                ->descriptionIcon('heroicon-m-document-plus')
                ->color('info'),
        ];
    }
}