<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class UsersChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Evoluție Utilizatori';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $months = collect(range(11, 0))->map(function ($months) {
            return Carbon::now()->startOfMonth()->subMonths($months);
        });

        $data = $months->mapWithKeys(function ($month) {
            return [
                $month->format('Y-m') => User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count()
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Utilizatori Noi',
                    'data' => $data->values()->toArray(),
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
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