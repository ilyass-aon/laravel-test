<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Property;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueOverview extends BaseWidget
{
    protected static bool $isDiscovered = false;
    

    protected function getStats(): array
    {
        // Toutes les réservations confirmées
        $confirmedBookings = Booking::where('status', 'confirmed')
            ->with('property')
            ->get();

        // Revenu total
        $totalRevenue = $confirmedBookings->sum(fn ($b) =>
            $b->start_date->diffInDays($b->end_date) * $b->property->price_per_night
        );

        // Revenu ce mois-ci
        $monthRevenue = $confirmedBookings
            ->filter(fn ($b) => $b->created_at->isCurrentMonth())
            ->sum(fn ($b) =>
                $b->start_date->diffInDays($b->end_date) * $b->property->price_per_night
            );

        // Revenu cette année
        $yearRevenue = $confirmedBookings
            ->filter(fn ($b) => $b->created_at->isCurrentYear())
            ->sum(fn ($b) =>
                $b->start_date->diffInDays($b->end_date) * $b->property->price_per_night
            );

        // Réservation la plus rentable
        $bestProperty = Property::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->first();

        return [
            Stat::make('Revenu total', number_format($totalRevenue, 0) . ' €')
                ->description('Toutes réservations confirmées')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Revenu ce mois', number_format($monthRevenue, 0) . ' €')
                ->description(now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Stat::make('Revenu cette année', number_format($yearRevenue, 0) . ' €')
                ->description((string) now()->year)
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('warning'),

            Stat::make('Bien le plus réservé', $bestProperty ? $bestProperty->name : 'N/A')
                ->description($bestProperty ? $bestProperty->bookings_count . ' réservations' : '')
                ->descriptionIcon('heroicon-m-star')
                ->color('danger'),
        ];
    }
}