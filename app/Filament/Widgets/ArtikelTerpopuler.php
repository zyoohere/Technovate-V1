<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Widgets\Widget;
use Filament\Tables;
use App\Models\Artikel;
use Illuminate\Database\Eloquent\Builder;

class ArtikelTerpopuler extends Widget
{
    protected static string $view = 'filament.widgets.artikel-terpopuler';

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Artikel::query()
            ->orderByDesc('view_count')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')->label('Judul'),
            Tables\Columns\TextColumn::make('view_count')->label('Dilihat'),
        ];
    }

    // The render() method is not needed as the parent Widget class handles rendering.
}
