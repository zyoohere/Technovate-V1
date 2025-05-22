<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ArtikelCategoryWidget extends BaseWidget implements Tables\Contracts\HasTable
{
    protected static string $view = 'filament.widgets.artikel-category-widget';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Category::query()
                    ->withCount('artikels')
                    ->with(['parent', 'children'])
                    ->having('artikels_count', '>', 0)
            )
            ->columns([
                TextColumn::make('parent.nama')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama')
                    ->label('Sub - Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('artikels_count')
                    ->label('Jumlah Artikel')
                    ->sortable()
                    ->color('primary'),
            ])
            ->filters([
                SelectFilter::make('parent_id')
                    ->label('Kategori')
                    ->relationship('parent', 'nama'),

            ]);
    }
}
