<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ArtikelTerpopuler;
use App\Filament\Widgets\DashboardOverview;
use App\Filament\Widgets\Komentar;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $title = 'Dashboard';

    public function getHeaderWidgets(): array
{
    return [
        DashboardOverview::class,
        ArtikelTerpopuler::class,
        Komentar::class,
    ];
}

     public function getTitle(): string
    {
        return __('Dashboard Technovate');
    }
}
