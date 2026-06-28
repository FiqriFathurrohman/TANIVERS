<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KomuditasResource\Pages;
use App\Models\Commodity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KomuditasResource extends Resource
{
    protected static ?string $model = Commodity::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Komoditas';
    protected static ?string $modelLabel = 'Komoditas';
    protected static ?string $pluralModelLabel = 'Komoditas';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Komoditas')
                    ->placeholder('Contoh: Cabai, Padi, Jagung')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Komoditas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('types_count')
                    ->label('Jumlah Jenis')
                    ->counts('types'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKomuditas::route('/'),
            'create' => Pages\CreateKomuditas::route('/create'),
            'edit' => Pages\EditKomuditas::route('/{record}/edit'),
        ];
    }
}