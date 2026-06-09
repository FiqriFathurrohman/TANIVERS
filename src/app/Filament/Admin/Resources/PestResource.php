<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PestResource\Pages;
use App\Models\CommodityType;
use App\Models\Pest;
use App\Models\SoilType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PestResource extends Resource
{
    protected static ?string $model = Pest::class;

    protected static ?string $navigationIcon = 'heroicon-o-bug-ant';
    protected static ?string $navigationLabel = 'Hama';
    protected static ?string $modelLabel = 'Hama';
    protected static ?string $pluralModelLabel = 'Hama';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 5;

    private static function weatherOptions(): array
    {
        return [
            'cerah' => 'Cerah',
            'cerah_berawan' => 'Cerah Berawan',
            'berawan' => 'Berawan',
            'hujan_ringan' => 'Hujan Ringan',
            'hujan_sedang' => 'Hujan Sedang',
            'hujan_lebat' => 'Hujan Lebat',
            'petir' => 'Hujan Petir',
            'kabut' => 'Kabut',
            'lembap' => 'Kelembapan Tinggi',
            'kering' => 'Cuaca Kering',
            'panas' => 'Suhu Tinggi',
            'angin_kencang' => 'Angin Kencang',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Hama')
                    ->placeholder('Contoh: Thrips, Wereng, Ulat Grayak')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Contoh: Hama ini menyerang pucuk dan daun muda.')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Section::make('Kecocokan Hama')
                    ->description('Pilih jenis komoditas, jenis tanah, dan kondisi cuaca yang mendukung kemunculan hama.')
                    ->schema([
                        Forms\Components\MultiSelect::make('commodityTypes')
                            ->label('Jenis Komoditas yang Rentan')
                            ->relationship('commodityTypes', 'name')
                            ->options(fn () => CommodityType::orderBy('name')->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\MultiSelect::make('soilTypes')
                            ->label('Jenis Tanah yang Berisiko')
                            ->relationship('soilTypes', 'name')
                            ->options(fn () => SoilType::orderBy('name')->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('weather_conditions')
                            ->label('Kondisi Cuaca')
                            ->options(fn () => self::weatherOptions())
                            ->multiple()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Hama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('commodityTypes.name')
                    ->label('Jenis Komoditas')
                    ->badge()
                    ->separator(',')
                    ->wrap(),

                Tables\Columns\TextColumn::make('soilTypes.name')
                    ->label('Jenis Tanah')
                    ->badge()
                    ->separator(',')
                    ->wrap(),

                Tables\Columns\TextColumn::make('weather_conditions')
                    ->label('Kondisi Cuaca')
                    ->badge()
                    ->getStateUsing(function (Pest $record): string {
                        $items = $record->weather_conditions;

                        if (empty($items)) {
                            return '-';
                        }

                        if (!is_array($items)) {
                            $items = json_decode($items, true);
                        }

                        if (!is_array($items)) {
                            return '-';
                        }

                        return collect($items)
                            ->map(fn ($item) => self::weatherOptions()[$item] ?? $item)
                            ->implode(', ');
                    })
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('commodityTypes')
                    ->label('Filter Jenis Komoditas')
                    ->relationship('commodityTypes', 'name'),

                Tables\Filters\SelectFilter::make('soilTypes')
                    ->label('Filter Jenis Tanah')
                    ->relationship('soilTypes', 'name'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
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
            'index' => Pages\ListPests::route('/'),
            'create' => Pages\CreatePest::route('/create'),
            'edit' => Pages\EditPest::route('/{record}/edit'),
        ];
    }
}