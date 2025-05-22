<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class Komentar extends BaseWidget implements Tables\Contracts\HasTable
{
    protected static ?string $heading = 'Komentar Terbaru';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(Comment::latest()->limit(5))
            ->columns([
                TextColumn::make('user.name')->label('User')->default('Guest'),
                TextColumn::make('artikel.title')->label('Artikel')->limit(20),
                TextColumn::make('content')->label('Komentar')->limit(40),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y, H:i'),
                TextColumn::make('status'),

            ]);
    }
}
