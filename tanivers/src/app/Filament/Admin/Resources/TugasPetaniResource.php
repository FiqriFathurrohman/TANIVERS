<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TugasPetaniResource\Pages;
use App\Models\JadwalTanam;
use App\Models\LogCeklistTanam;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Support\Facades\Auth;

class TugasPetaniResource extends Resource
{
    protected static ?string $model = JadwalTanam::class; 

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    
    protected static ?string $navigationGroup = 'Kegiatan Lapangan'; 
    
    protected static ?string $pluralModelLabel = 'Ceklist Tugas Mandiri';
    protected static ?string $modelLabel = 'Tugas Lapangan';

    // Perbaikan sintaks: Menggunakan kurung kurawal standar agar tidak ParseError
    public static function canCreate(): bool 
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jenisPadi.nama')
                    ->label('Varietas Padi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('minggu_ke')
                    ->label('Minggu')
                    ->formatStateUsing(fn (string $state): string => "Minggu Ke-{$state}")
                    ->sortable(),

                TextColumn::make('fase_masa')
                    ->label('Fase Pertumbuhan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Awal Tanam / Vegetatif', 'Anakan Aktif / Vegetatif' => 'info',
                        'Bunting / Generatif', 'Keluar Malai / Generatif' => 'warning',
                        'Pematangan / Matang Susu' => 'success',
                        default => 'success',
                    }),

                TextColumn::make('instruksi_kegiatan')
                    ->label('Instruksi Tugas (SOP)')
                    ->wrap()
                    ->limit(150),

                CheckboxColumn::make('is_completed')
                    ->label('Status Selesai')
                    ->getStateUsing(function (JadwalTanam $record) {
                        return LogCeklistTanam::where('user_id', Auth::id())
                            ->where('jadwal_tanam_id', $record->id)
                            ->where('is_completed', true)
                            ->exists();
                    })
                    ->updateStateUsing(function (JadwalTanam $record, $state) {
                        if ($state) {
                            LogCeklistTanam::updateOrCreate(
                                [
                                    'user_id' => Auth::id(),
                                    'jadwal_tanam_id' => $record->id,
                                ],
                                [
                                    'is_completed' => true,
                                    'completed_at' => now(),
                                ]
                            );
                        } else {
                            LogCeklistTanam::where('user_id', Auth::id())
                                ->where('jadwal_tanam_id', $record->id)
                                ->delete();
                        }
                    })
                    ->alignCenter(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_padi_id')
                    ->label('Filter Varietas Padi')
                    ->relationship('jenisPadi', 'nama')
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTugasPetanis::route('/'),
        ];
    }
}