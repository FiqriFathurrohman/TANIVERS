<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PlantingGuideResource\Pages;
use App\Models\Commodity;
use App\Models\CommodityType;
use App\Models\PlantingGuide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Exceptions\Halt;
use Filament\Tables;
use Filament\Tables\Table;

class PlantingGuideResource extends Resource
{
    protected static ?string $model = PlantingGuide::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Panduan Masa Tanam';

    protected static ?string $modelLabel = 'Panduan Masa Tanam';

    protected static ?string $pluralModelLabel = 'Panduan Masa Tanam';

    protected static ?string $navigationGroup = 'Manajemen Tanam';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Komoditas')
                    ->description('Tentukan komoditas, jenis komoditas, dan total lama masa tanam.')
                    ->schema([
                        Forms\Components\Select::make('commodity_id')
                            ->label('Komoditas')
                            ->placeholder('Pilih komoditas')
                            ->options(fn () => Commodity::query()
                                ->where('is_active', true)
                                ->orderBy('name')
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Set $set) {
                                $set('commodity_type_id', null);
                            }),

                        Forms\Components\Select::make('commodity_type_id')
                            ->label('Jenis Komoditas')
                            ->placeholder('Pilih jenis komoditas')
                            ->options(function (Get $get, ?PlantingGuide $record = null) {
                                $commodityId = $get('commodity_id');

                                if (! $commodityId) {
                                    return [];
                                }

                                $usedActiveCommodityTypeIds = PlantingGuide::query()
                                    ->where('is_active', true)
                                    ->when($record, function ($query) use ($record) {
                                        $query->where('id', '!=', $record->id);
                                    })
                                    ->pluck('commodity_type_id')
                                    ->toArray();

                                return CommodityType::query()
                                    ->where('commodity_id', $commodityId)
                                    ->where('is_active', true)
                                    ->whereNotIn('id', $usedActiveCommodityTypeIds)
                                    ->orderBy('name')
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn (Get $get) => blank($get('commodity_id')))
                            ->helperText('Jenis komoditas yang sudah memiliki panduan aktif tidak akan muncul.'),

                        Forms\Components\TextInput::make('duration_days')
                            ->label('Lama Masa Tanam')
                            ->helperText('Contoh: 120 hari dari awal tanam sampai panen.')
                            ->numeric()
                            ->required()
                            ->default(120)
                            ->minValue(1)
                            ->suffix('hari'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Fase Masa Tanam')
                    ->description('Tentukan fase dari hari berapa sampai hari berapa, misalnya Penyemaian, Vegetatif, Generatif, Pematangan, Panen.')
                    ->schema([
                        Forms\Components\Repeater::make('phases')
                            ->label('Daftar Fase')
                            ->relationship()
                            ->orderColumn('sort_order')
                            ->schema([
                                Forms\Components\TextInput::make('start_day')
                                    ->label('Hari Awal Fase')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->live(),

                                Forms\Components\TextInput::make('end_day')
                                    ->label('Hari Akhir Fase')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->live(),

                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Fase')
                                    ->placeholder('Contoh: Penyemaian')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Fase')
                                    ->placeholder('Contoh: Fase awal untuk menyiapkan bibit sebelum pindah tanam.')
                                    ->rows(2)
                                    ->columnSpanFull(),

                                Forms\Components\Repeater::make('tasks')
                                    ->label('List Tugas pada Fase Ini')
                                    ->relationship()
                                    ->orderColumn('sort_order')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Nama Tugas')
                                            ->placeholder('Contoh: Menyiram bibit')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('description')
                                            ->label('Deskripsi Tugas')
                                            ->placeholder('Contoh: Siram bibit pada pagi atau sore hari sesuai kondisi media tanam.')
                                            ->rows(2)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('start_day')
                                            ->label('Tugas Muncul Mulai Hari')
                                            ->numeric()
                                            ->required()
                                            ->minValue(1),

                                        Forms\Components\TextInput::make('end_day')
                                            ->label('Tugas Muncul Sampai Hari')
                                            ->numeric()
                                            ->required()
                                            ->minValue(1),

                                        Forms\Components\Select::make('repeat_type')
                                            ->label('Pola Muncul Tugas')
                                            ->options([
                                                'once' => 'Sekali saja',
                                                'daily' => 'Setiap hari',
                                                'interval' => 'Setiap beberapa hari',
                                            ])
                                            ->default('daily')
                                            ->live()
                                            ->required(),

                                        Forms\Components\TextInput::make('repeat_interval_days')
                                            ->label('Muncul Setiap Berapa Hari')
                                            ->numeric()
                                            ->minValue(1)
                                            ->placeholder('Contoh: 3')
                                            ->helperText('Isi jika pola muncul tugas adalah setiap beberapa hari.')
                                            ->visible(fn (Get $get) => $get('repeat_type') === 'interval'),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(1)
                                    ->addActionLabel('Tambah Tugas')
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Tugas Baru')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Fase')
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Fase Baru')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('commodity.name')
                    ->label('Komoditas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('commodityType.name')
                    ->label('Jenis Komoditas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('duration_days')
                    ->label('Masa Tanam')
                    ->suffix(' hari')
                    ->sortable(),

                Tables\Columns\TextColumn::make('phases_count')
                    ->label('Jumlah Fase')
                    ->counts('phases'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->onColor('success')
                    ->offColor('danger')
                    ->updateStateUsing(function (PlantingGuide $record, bool $state): bool {
                        if ($state) {
                            $alreadyActive = PlantingGuide::query()
                                ->where('id', '!=', $record->id)
                                ->where('commodity_type_id', $record->commodity_type_id)
                                ->where('is_active', true)
                                ->exists();

                            if ($alreadyActive) {
                                Notification::make()
                                    ->title('Tidak Bisa Mengaktifkan')
                                    ->body('Jenis komoditas ini sudah memiliki panduan masa tanam yang aktif.')
                                    ->danger()
                                    ->send();

                                return false;
                            }
                        }

                        $record->update([
                            'is_active' => $state,
                        ]);

                        return $state;
                    }),

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

    public static function validateGuideFlow(array $data, ?PlantingGuide $record = null): void
    {
        $durationDays = (int) ($data['duration_days'] ?? 0);
        $commodityTypeId = $data['commodity_type_id'] ?? null;
        $isActive = (bool) ($data['is_active'] ?? false);
        $phases = $data['phases'] ?? [];

        $errors = [];

        if ($durationDays < 1) {
            $errors[] = 'Lama masa tanam harus lebih dari 0 hari.';
        }

        if ($isActive && $commodityTypeId) {
            $alreadyActive = PlantingGuide::query()
                ->where('commodity_type_id', $commodityTypeId)
                ->where('is_active', true)
                ->when($record, function ($query) use ($record) {
                    $query->where('id', '!=', $record->id);
                })
                ->exists();

            if ($alreadyActive) {
                $errors[] = 'Jenis komoditas ini sudah memiliki panduan masa tanam yang aktif. Nonaktifkan data lama terlebih dahulu atau edit data yang sudah ada.';
            }
        }

        if (empty($phases)) {
            $errors[] = 'Minimal harus ada 1 fase masa tanam.';
        }

        $phaseRanges = [];

        foreach ($phases as $phaseIndex => $phase) {
            $phaseNumber = is_numeric($phaseIndex) ? $phaseIndex + 1 : count($phaseRanges) + 1;

            $phaseStart = (int) ($phase['start_day'] ?? 0);
            $phaseEnd = (int) ($phase['end_day'] ?? 0);
            $phaseName = filled($phase['name'] ?? null) ? $phase['name'] : "Fase {$phaseNumber}";

            if ($phaseStart < 1) {
                $errors[] = "{$phaseName}: hari awal fase minimal hari ke-1.";
            }

            if ($phaseEnd < $phaseStart) {
                $errors[] = "{$phaseName}: hari akhir fase tidak boleh lebih kecil dari hari awal fase.";
            }

            if ($phaseEnd > $durationDays) {
                $errors[] = "{$phaseName}: hari akhir fase tidak boleh melebihi total {$durationDays} hari.";
            }

            $phaseRanges[] = [
                'name' => $phaseName,
                'start_day' => $phaseStart,
                'end_day' => $phaseEnd,
            ];

            $tasks = $phase['tasks'] ?? [];

            foreach ($tasks as $taskIndex => $task) {
                $taskNumber = is_numeric($taskIndex) ? $taskIndex + 1 : 1;

                $taskStart = (int) ($task['start_day'] ?? 0);
                $taskEnd = (int) ($task['end_day'] ?? 0);
                $taskTitle = filled($task['title'] ?? null) ? $task['title'] : "Tugas {$taskNumber}";
                $repeatType = $task['repeat_type'] ?? 'daily';
                $repeatInterval = (int) ($task['repeat_interval_days'] ?? 0);

                if ($taskStart < 1) {
                    $errors[] = "{$phaseName} - {$taskTitle}: hari mulai tugas minimal hari ke-1.";
                }

                if ($taskEnd < $taskStart) {
                    $errors[] = "{$phaseName} - {$taskTitle}: hari akhir tugas tidak boleh lebih kecil dari hari mulai tugas.";
                }

                if ($taskStart < $phaseStart || $taskEnd > $phaseEnd) {
                    $errors[] = "{$phaseName} - {$taskTitle}: hari tugas harus berada dalam rentang fase hari {$phaseStart} sampai {$phaseEnd}.";
                }

                if ($taskEnd > $durationDays) {
                    $errors[] = "{$phaseName} - {$taskTitle}: hari tugas tidak boleh melebihi total masa tanam {$durationDays} hari.";
                }

                if ($repeatType === 'once' && $taskStart !== $taskEnd) {
                    $errors[] = "{$phaseName} - {$taskTitle}: jika pola 'Sekali saja', hari mulai dan hari akhir harus sama.";
                }

                if ($repeatType === 'interval' && $repeatInterval < 1) {
                    $errors[] = "{$phaseName} - {$taskTitle}: isi jumlah hari interval minimal 1.";
                }
            }
        }

        usort($phaseRanges, fn ($a, $b) => $a['start_day'] <=> $b['start_day']);

        $previousEnd = 0;
        $previousName = null;

        foreach ($phaseRanges as $range) {
            if ($range['start_day'] <= $previousEnd) {
                $errors[] = "Fase {$range['name']} bertabrakan dengan fase {$previousName}. Pastikan rentang hari fase tidak tumpang tindih.";
            }

            $previousEnd = $range['end_day'];
            $previousName = $range['name'];
        }

        if (! empty($errors)) {
            Notification::make()
                ->title('Validasi Panduan Masa Tanam Gagal')
                ->body(implode("\n", $errors))
                ->danger()
                ->persistent()
                ->send();

            throw new Halt();
        }
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlantingGuides::route('/'),
            'create' => Pages\CreatePlantingGuide::route('/create'),
            'edit' => Pages\EditPlantingGuide::route('/{record}/edit'),
        ];
    }
}