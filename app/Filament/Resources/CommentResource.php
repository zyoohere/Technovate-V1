<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $label = 'Comment';
    protected static ?string $pluralLabel = 'Comments';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('artikel_id')
                    ->relationship('artikel', 'title') // Ganti 'title' sesuai kolom judul artikel
                    ->required()
                    ->label('Artikel'),

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'role') // Pastikan kolom 'name' tersedia di tabel users
                    ->searchable()
                    ->label('User')
                    ->nullable(),

                Forms\Components\TextInput::make('guest_name')
                    ->label('Guest Name')
                    ->maxLength(100)
                    ->nullable(),

                Forms\Components\TextInput::make('ip_address')
                    ->label('IP Address')
                    ->maxLength(45)
                    ->nullable()
                    ->disabled(), // biasanya tidak perlu diedit

                Forms\Components\Textarea::make('content')
                    ->label('Comment')
                    ->required()
                    ->rows(4),

                Forms\Components\Select::make('parent_id')
                    ->relationship('parent', 'id') // bisa disesuaikan, misalnya 'content' pendek
                    ->label('Parent Comment')
                    ->nullable(),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required()
                    ->label('Status'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('artikel.title')
                    ->label('Artikel')
                    ->limit(30)
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Guest Name'),
                Tables\Columns\TextColumn::make('content')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->content),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn($record) => $record->status !== 'approved')
                    ->action(fn($record) => $record->update(['status' => 'approved'])),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn($record) => $record->status !== 'rejected')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->update(['status' => 'rejected'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
