<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CommodityTypeResource\Pages;
use App\Models\Commodity;
use App\Models\CommodityType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommodityTypeResource extends Resource
{
    protected static ?string $model = CommodityType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Jenis Komoditas';

    protected static ?string $modelLabel = 'Jenis Komoditas';

    protected static ?string $pluralModelLabel = 'Jenis Komoditas';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('commodity_id')
                    ->label('Komoditas')
                    ->placeholder('Pilih Komoditas')
                    ->options(function () {
                        return Commodity::orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->label('Nama Jenis Komoditas')
                    ->placeholder('Contoh: Cabai Setan, Cabai Rawit, Padi Ciherang')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('commodity.name')
                    ->label('Komoditas')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Jenis Komoditas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('commodity_id')
                    ->label('Komoditas')
                    ->options(function () {
                        return Commodity::orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray();
                    }),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommodityTypes::route('/'),
            'create' => Pages\CreateCommodityType::route('/create'),
            'edit' => Pages\EditCommodityType::route('/{record}/edit'),
        ];
    }
}