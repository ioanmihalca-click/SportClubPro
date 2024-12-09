<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Club;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $userCount = User::count();
        $lastMonthUsers = User::where('created_at', '<=', now()->subMonth())->count();
        $userGrowth = $lastMonthUsers ? round((($userCount - $lastMonthUsers) / $lastMonthUsers) * 100, 1) : 0;
        
        $clubCount = Club::count();
        $lastMonthClubs = Club::where('created_at', '<=', now()->subMonth())->count();
        $clubGrowth = $lastMonthClubs ? round((($clubCount - $lastMonthClubs) / $lastMonthClubs) * 100, 1) : 0;

        return [
            BaseWidget\Stat::make('Utilizatori Totali', $userCount)
                ->description($userGrowth > 0 ? "+{$userGrowth}% față de luna trecută" : "{$userGrowth}% față de luna trecută")
                ->descriptionIcon($userGrowth > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($userGrowth > 0 ? 'success' : 'danger')
                ->chart(User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->limit(30)
                    ->pluck('count')
                    ->toArray()),

            BaseWidget\Stat::make('Cluburi Active', $clubCount)
                ->description($clubGrowth > 0 ? "+{$clubGrowth}% față de luna trecută" : "{$clubGrowth}% față de luna trecută")
                ->descriptionIcon($clubGrowth > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($clubGrowth > 0 ? 'success' : 'danger')
                ->chart(Club::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->limit(30)
                    ->pluck('count')
                    ->toArray()),
        ];
    }
}