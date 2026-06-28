<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SoilTypeResource\Pages;
use App\Models\SoilType;
use App\Models\CommodityType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SoilTypeResource extends Resource
{
    protected static ?string $model = SoilType::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Jenis Tanah';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Jenis Tanah')
                    ->placeholder('Contoh: Lempung, Pasir, Humus')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),

                // Multi-select pakai CommodityType
                Forms\Components\MultiSelect::make('commodityTypes')
                    ->label('Jenis Komoditas yang Cocok')
                    ->relationship('commodityTypes', 'name')
                    ->preload()
                    ->columns(2)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Jenis Tanah')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('commodityTypes_count')
                    ->counts('commodityTypes')
                    ->label('Jumlah Jenis Komoditas'),

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
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus Terpilih'),
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
            'index' => Pages\ListSoilTypes::route('/'),
            'create' => Pages\CreateSoilType::route('/create'),
            'edit' => Pages\EditSoilType::route('/{record}/edit'),
        ];
    }
}