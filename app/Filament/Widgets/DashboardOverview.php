<?php

namespace App\Filament\Widgets;

use App\Models\Artikel;
use App\Models\User;
use App\Models\Comment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Artikel', Artikel::count())
                ->description('Jumlah semua artikel')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('success'),

            Stat::make('Total Komentar', Comment::count())
                ->description('Komentar yang masuk')
                ->descriptionIcon('heroicon-o-chat-bubble-left')
                ->color('info'),

            Stat::make('User Aktif', User::count())
                ->description('User dengan status aktif')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary'),
        ];
    }
}
