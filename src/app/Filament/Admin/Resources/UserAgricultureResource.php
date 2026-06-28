<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserAgricultureResource\Pages;
use App\Models\ExecutionExpense;
use App\Models\ExecutionPestReport;
use App\Models\Lahan;
use App\Models\PreProductionPlan;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserAgricultureResource extends Resource
{
    protected static ?string $model = User::class;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Data User';

    protected static ?string $modelLabel = 'Data User';

    protected static ?string $pluralModelLabel = 'Data User';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 99;

    protected static ?string $slug = 'data-user-pertanian';

    public static function canAccess(): bool
    {
        return true;
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canView($record): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_lahan')
                    ->label('Jumlah Lahan')
                    ->getStateUsing(function (User $record): int {
                        return Lahan::where('user_id', $record->id)->count();
                    })
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('jumlah_pra_production')
                    ->label('Pra Production')
                    ->getStateUsing(function (User $record): int {
                        return PreProductionPlan::where('user_id', $record->id)->count();
                    })
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('jumlah_laporan')
                    ->label('Laporan Hama/Penyakit')
                    ->getStateUsing(function (User $record): int {
                        return ExecutionPestReport::where('user_id', $record->id)->count();
                    })
                    ->badge()
                    ->color('danger'),

                Tables\Columns\TextColumn::make('total_pengeluaran')
                    ->label('Total Pengeluaran')
                    ->getStateUsing(function (User $record): string {
                        $total = ExecutionExpense::where('user_id', $record->id)->sum('total_amount');

                        return 'Rp ' . number_format($total, 0, ',', '.');
                    })
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Riwayat'),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserAgricultures::route('/'),
            'view' => Pages\ViewUserAgriculture::route('/{record}'),
        ];
    }
}