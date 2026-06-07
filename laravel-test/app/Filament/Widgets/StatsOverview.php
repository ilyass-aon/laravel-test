<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Booking;
use App\Models\Property;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalProperties = Property::count();

        $totalBookings = Booking::count();

        $pendingBookings = Booking::where('status', 'pending')->count();

        $reservedProperties = Property::whereHas('bookings', fn ($q) =>
            $q->where('status', 'confirmed')
              ->where('start_date', '<=', today())
              ->where('end_date', '>=', today())
        )->count();

        $occupancyRate = $totalProperties > 0
            ? round(($reservedProperties / $totalProperties) * 100)
            : 0;

        return [
            Stat::make('Total propriétés', $totalProperties)
                ->description('Ensemble des biens enregistrés')
                ->descriptionIcon('heroicon-m-home')
                ->color('primary'),

            Stat::make('Total réservations', $totalBookings)
                ->description('Toutes réservations confondues')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),

            Stat::make('En attente', $pendingBookings)
                ->description('Toutes les réservations à traiter')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Taux d\'occupation', $occupancyRate . '%')
                ->description('Propriétés actuellement réservées')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('danger'),
        ];
    }
}
