<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;


class Komentar extends BaseWidget
{
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Comment::query()
            ->orderByDesc('status')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('content')->label('Judul'),
            Tables\Columns\TextColumn::make('status')->label('Dilihat'),
        ];
    }
}
