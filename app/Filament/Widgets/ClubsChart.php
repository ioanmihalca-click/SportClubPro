<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Club;
use Filament\Widgets\ChartWidget;

class ClubsChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Evoluție Cluburi';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $months = collect(range(11, 0))->map(function ($months) {
            return Carbon::now()->startOfMonth()->subMonths($months);
        });

        $data = $months->mapWithKeys(function ($month) {
            return [
                $month->format('Y-m') => Club::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count()
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Cluburi Noi',
                    'data' => $data->values()->toArray(),
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'borderColor' => 'rgb(139, 92, 246)',
                    'tension' => 0.2,
                ],
            ],
            'labels' => $data->keys()->map(function ($month) {
                return Carbon::createFromFormat('Y-m', $month)->format('M Y');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}