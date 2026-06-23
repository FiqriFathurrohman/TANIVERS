<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DiseaseResource\Pages;
use App\Models\CommodityType;
use App\Models\Disease;
use App\Models\SoilType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DiseaseResource extends Resource
{
    protected static ?string $model = Disease::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?string $navigationLabel = 'Penyakit';
    protected static ?string $modelLabel = 'Penyakit';
    protected static ?string $pluralModelLabel = 'Penyakit';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 6;

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
                    ->label('Nama Penyakit')
                    ->placeholder('Contoh: Hawar Daun, Busuk Akar, Layu Fusarium')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi / Gejala')
                    ->placeholder('Contoh: Daun menguning, muncul bercak cokelat, tanaman layu, atau pertumbuhan terhambat.')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('solution')
                    ->label('Rekomendasi Penanganan')
                    ->placeholder('Contoh: Gunakan benih sehat, atur jarak tanam, kurangi kelembapan berlebih, dan gunakan fungisida sesuai anjuran.')
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\Section::make('Kecocokan Penyakit')
                    ->description('Pilih jenis komoditas, jenis tanah, dan kondisi cuaca yang mendukung kemunculan penyakit.')
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
                    ->label('Nama Penyakit')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('solution')
                    ->label('Rekomendasi')
                    ->limit(70)
                    ->wrap()
                    ->searchable(),

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
                    ->getStateUsing(function (Disease $record): string {
                        $items = $record->weather_conditions;

                        if (empty($items)) {
                            return '-';
                        }

                        if (! is_array($items)) {
                            $items = json_decode($items, true);
                        }

                        if (! is_array($items)) {
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
            'index' => Pages\ListDiseases::route('/'),
            'create' => Pages\CreateDisease::route('/create'),
            'edit' => Pages\EditDisease::route('/{record}/edit'),
        ];
    }
}