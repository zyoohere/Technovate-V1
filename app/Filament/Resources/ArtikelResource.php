<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelResource\Pages;
use App\Models\Artikel;
use App\Models\Category;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\{
    ImageEntry,
    Section as InfolistsSection,
    TextEntry
};
use Filament\Forms\Components\{
    DatePicker,
    TextInput,
    Textarea,
    Toggle,
    Select,
    FileUpload,
    RichEditor,
    DateTimePicker
};
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\DateFilter;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Mail\Mailables\Content;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;


    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Artikel';
    protected static ?string $pluralModelLabel = 'Artikel';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?string $modelLabel = 'Artikel';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')
                ->label('Penulis')
                ->relationship(
                    name: 'user',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn($query) => $query->where('role', 'author')
                )
                ->preload()
                ->searchable()
                ->required(),

            Select::make('category_id')
                ->relationship('category', 'nama') // <-- Ini WAJIB agar relasi dikenali
                ->preload()
                ->searchable()
                ->required(),

            TextInput::make('title')
                ->label('Judul')
                ->live(onBlur: true)
                ->afterStateUpdated(function (?string $state, Get $get, Set $set) {
                    if (blank($get('slug'))) {
                        $set('slug', Str::slug($get('title')));
                    }
                })
                ->maxLength(255)
                ->required(),

            TextInput::make('slug')
                ->readOnly()
                ->required()
                ->unique(Artikel::class, 'slug', ignoreRecord: true),
            RichEditor::make('content')
                ->label('Konten Artikel')
                ->reactive()
                ->toolbarButtons([
                    'bold',
                    'italic',
                    'underline',
                    'strike',
                    'codeBlock',
                    'blockquote',
                    'bulletedList',
                    'numberedList',
                    'link',
                ])
                ->required(),

            Textarea::make('excerpt')
                ->label('Ringkasan')
                ->disabled()
                ->dehydrated(false)
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('excerpt', \Illuminate\Support\Str::words(strip_tags($state), 30));
                }),


            FileUpload::make('image')
                ->label('Gambar')
                ->image()
                ->disk('public')
                ->preserveFilenames()
                ->directory('artikels')
                ->required(),

            Select::make('tags')
                ->label('Tag')
                ->multiple()
                ->relationship('tags', 'nama')
                ->preload()
                ->searchable()
                ->saveRelationshipsUsing(function ($record, $state) {
                    $record->tags()->sync($state);
                }),

            Select::make('status')
                ->label('Status Artikel')
                ->options([
                    'draft' => 'Draft (Belum selesai)',
                    'review' => 'Menunggu Review',
                    'published' => 'Sudah Diterbitkan',
                    'archived' => 'Diarsipkan',
                ])
                ->required(),

            Toggle::make('is_featured')->label('Tampilkan di Beranda'),

            DateTimePicker::make('published_at')->label('Tanggal Publikasi'),

            DateTimePicker::make('updated_at')
                ->label('Tanggal Diperbarui')
                ->disabled()
                ->hiddenOn('create')
                ->timezone('Asia/Jakarta')
                ->default(now())
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')
                ->label('Judul')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('user.name')
                ->label('Penulis'),

            Tables\Columns\TextColumn::make('category.nama')
                ->label('Kategori'),

            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn($state) => match ($state) {
                    'draft' => 'warning',
                    'published' => 'success',
                    'review' => 'gray',
                    'archived' => 'gray',
                }),

            Tables\Columns\IconColumn::make('is_featured')
                ->label('Beranda')
                ->boolean(),


            Tables\Columns\TextColumn::make('published_at')
                ->label('Publikasi')
                ->dateTime(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime(),
        ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Penulis')
                    ->multiple()

                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn($query) => $query->where('role', 'author')
                    )
                    ->preload(),
                SelectFilter::make('status')
                    ->label('Status')
                    ->multiple()
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Publikasi',
                        'review' => 'Review',
                        'archived' => 'Diarsipkan',
                    ]),
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->multiple()
                    ->relationship('category', 'nama'),
                SelectFilter::make('tags')
                    ->label('Tag')
                    ->multiple()
                    ->relationship('tags', 'nama'),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->searchable('title')
            ->filtersFormMaxHeight('400px')
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->visible(fn($record) => $record->status === 'review')
                    ->action(fn($record) => $record->update(['status' => 'published'])),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn($record) => $record->status === 'review')
                    ->action(fn($record) => $record->update(['status' => 'draft'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfolistsSection::make([
                ImageEntry::make('image')
                    ->label('Gambar')
                    ->size(200),

                TextEntry::make('title')
                    ->label('Judul')
                    ->size('lg')
                    ->weight('bold'),

                TextEntry::make('user.name')
                    ->label('Penulis'),

                TextEntry::make('content')
                    ->label('Konten')
                    ->html()
                    ->alignJustify(),

                TextEntry::make('tags')
                    ->label('Tag')
                    ->state(function ($record) {
                        return $record->tags->pluck('nama')->join(', ');
                    }),

            ])->columnSpan(2),

            InfolistsSection::make([
                TextEntry::make('category.nama')
                    ->label('Kategori'),

                TextEntry::make('created_at')
                    ->label('Tanggal Dibuat'),

                TextEntry::make('updated_at')
                    ->label('Tanggal Diperbarui'),

                TextEntry::make('published_at')
                    ->label('Tanggal Publikasi'),

                TextEntry::make('status')
                    ->label('Status'),
            ])->columnSpan(1),
        ])->columns(3);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan jika ada RelationManager (misal: komentar, tag, dsb.)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit' => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }
}
