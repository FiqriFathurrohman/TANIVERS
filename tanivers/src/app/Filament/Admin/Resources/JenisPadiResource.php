<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JenisPadiResource\Pages;
use App\Models\JenisPadi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;

class JenisPadiResource extends Resource
{
    protected static ?string $model = JenisPadi::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    
    protected static ?string $navigationGroup = 'Administration'; 
    
    protected static ?string $pluralModelLabel = 'Jenis Padi';
    protected static ?string $modelLabel = 'Jenis Padi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama Varietas')
                    ->description('Data spesifikasi varietas padi.')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Varietas Padi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Inpari 32, Ciherang'),

                        TextInput::make('usia_tanam_hari')
                            ->label('Usia Tanam (Hari)')
                            ->numeric()
                            ->suffix('Hari')
                            ->placeholder('Contoh: 120'),

                        TextInput::make('potensi_hasil')
                            ->label('Potensi Hasil Panen')
                            ->maxLength(255)
                            ->placeholder('Contoh: 8.4 Ton/Ha'),
                    ])->columns(3),

                Section::make('Detail Karakteristik')
                    ->schema([
                        Textarea::make('ketahanan_hama')
                            ->label('Ketahanan Hama & Penyakit')
                            ->rows(3)
                            ->placeholder('Contoh: Tahan terhadap Wereng Coklat Biotipe 1 & 2.'),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi Tambahan')
                            ->rows(3)
                            ->placeholder('Masukkan catatan tambahan mengenai karakteristik nasi.'),
                    ])->columns(1),

                // SECTION BARU: PANDUAN TIMELINE MINGGUAN (REPEATER)
                Section::make('Panduan Fase Masa Tanam & SOP Mingguan')
                    ->description('Tentukan instruksi kegiatan operasional petani dari minggu ke minggu.')
                    ->schema([
                        Repeater::make('jadwalTanams') // Nama fungsi relasi di Model JenisPadi
                            ->relationship('jadwalTanams')
                            ->schema([
                                TextInput::make('minggu_ke')
                                    ->label('Minggu Ke-')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Minggu')
                                    ->placeholder('Misal: 1'),

                                Select::make('fase_masa')
                                    ->label('Masuk Masa / Fase')
                                    ->required()
                                    ->options([
                                        'Awal Tanam / Vegetatif' => 'Awal Tanam / Vegetatif',
                                        'Anakan Aktif / Vegetatif' => 'Anakan Aktif / Vegetatif',
                                        'Bunting / Generatif' => 'Bunting / Generatif',
                                        'Keluar Malai / Generatif' => 'Keluar Malai / Generatif',
                                        'Pematangan / Matang Susu' => 'Pematangan / Matang Susu',
                                        'Siap Panen' => 'Siap Panen',
                                    ])
                                    ->preload(),

                                Textarea::make('instruksi_kegiatan')
                                    ->label('Instruksi Kegiatan Petani (Harus Ngapain)')
                                    ->required()
                                    ->placeholder('Contoh: Minggu pertama lakukan pengairan macak-macak, cek gulma awal, dan persiapkan pemupukan dasar menggunakan Urea & SP-36.')
                                    ->rows(2)
                                    ->columnSpan(2),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Instruksi Minggu Baru')
                            ->reorderableWithButtons()
                            ->collapsible(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Varietas')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('usia_tanam_hari')
                    ->label('Usia Tanam')
                    ->sortable()
                    ->suffix(' Hari')
                    ->alignCenter(),

                TextColumn::make('potensi_hasil')
                    ->label('Potensi Hasil')
                    ->searchable()
                    ->badge()
                    ->color('success'),

                // Menampilkan jumlah minggu panduan yang sudah dibuat oleh admin
                TextColumn::make('jadwal_tanams_count')
                    ->label('Total Panduan SOP')
                    ->counts('jadwalTanams')
                    ->suffix(' Minggu Panduan')
                    ->alignCenter()
                    ->badge()
                    ->color('info'),
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
            'index' => Pages\ListJenisPadis::route('/'),
            'create' => Pages\CreateJenisPadi::route('/create'),
            'edit' => Pages\EditJenisPadi::route('/{record}/edit'),
        ];
    }
}