<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\RevenueOverview;
use App\Filament\Widgets\RevenueChart;

class RevenueReport extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-pie';
    protected static ?string $navigationLabel = 'Rapports & Revenus';
    protected static ?string $title = 'Bilan des revenus';
    protected static ?int $navigationSort = 90; // Just before Espace Client which is 100

    protected string $view = 'filament.pages.revenue-report';

    protected function getHeaderWidgets(): array
    {
        return [
            RevenueOverview::class,
            RevenueChart::class,
        ];
    }
}
