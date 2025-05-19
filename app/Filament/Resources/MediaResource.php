<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $label = 'Media';
    protected static ?string $pluralLabel = 'Media Items';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Select::make('artikel_id')
                        ->relationship('artikel', 'title') // Ganti 'title' sesuai nama kolom yang cocok
                        ->nullable()
                        ->preload()
                        ->required(),
                    TextInput::make('caption')
                        ->label('Judul/Caption')
                        ->maxLength(255),
                    Select::make('type')
                        ->label('Tipe Media')
                        ->options([
                            'image' => 'Gambar',
                            'video' => 'Video',
                            'document' => 'Dokumen',
                            'external' => 'Tautan Eksternal (YouTube, Vimeo)',
                        ])
                        ->reactive()
                        ->required(),

                    FileUpload::make('media_path')
                        ->label('Unggah File')
                        ->disk('public')
                        ->directory('media')
                        ->preserveFilenames()
                        ->visible(fn($get) => in_array($get('type'), ['image', 'video', 'document']))
                        ->required(fn($get) => in_array($get('type'), ['image', 'video', 'document'])),

                    TextInput::make('media_url')
                        ->label('Tautan Eksternal')
                        ->url()
                        ->visible(fn($get) => $get('type') === 'external')
                        ->required(fn($get) => $get('type') === 'external'),

                    Toggle::make('is_featured')
                        ->label('Tampilkan di Beranda'),

                    TextInput::make('order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('artikel.title')
                    ->label('Artikel')
                    ->wrap()
                    ->formatStateUsing(fn($state, $record) => $record->artikel?->title ?? '-')
                    ->formatStateUsing(fn($record) => $record->artikel?->title ?? '-'),
                Tables\Columns\TextColumn::make('caption')->label('Judul')->limit(30),
                Tables\Columns\TextColumn::make('type')->label('Tipe')->badge(),
                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('Beranda'),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime(),

            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured'),
                Tables\Filters\SelectFilter::make('artikel_id')
                    ->label('Artikel')
                    ->relationship('artikel', 'title')
                    ->placeholder('Semua'),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe Media')
                    ->options([
                        'image' => 'Image',
                        'video' => 'Video',
                        'document' => 'Dokumen',
                        'external' => 'External',
                    ])
                    ->label('Media Type')
                    ->placeholder('All Types'),
            ])
            ->striped()
            ->striped()
            ->paginated([10, 25, 50])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
