<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Évolution des revenus par mois';
    protected static bool $isDiscovered = false;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = [];
        $revenues = [];

        // les revenus des 6 derniers mois
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->translatedFormat('M Y');

            $revenue = Booking::where('status', 'confirmed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->with('property')
                ->get()
                ->sum(fn ($b) => $b->start_date->diffInDays($b->end_date) * $b->property->price_per_night);

            $revenues[] = $revenue;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenus (EUR)',
                    'data' => $revenues,
                    'borderColor' => '#1E40AF', // Primary color
                    'backgroundColor' => 'rgba(30, 64, 175, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
