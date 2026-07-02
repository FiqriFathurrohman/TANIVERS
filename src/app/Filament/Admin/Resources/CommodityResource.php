<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CommodityResource\Pages;
use App\Filament\Admin\Resources\CommodityResource\RelationManagers;
use App\Models\Commodity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommodityResource extends Resource
{
    protected static ?string $model = Commodity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    // --- TAMBAHAN DARI GUA BIAR RAPI & NONGOL ---
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Komoditas';
    protected static ?string $pluralModelLabel = 'Komoditas';

    // Kunci Master: Paksa menu ini nongol buat admin
    public static function canViewAny(): bool
    {
        return true;
    }
    // ---------------------------------------------

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\TextInput::make('max_consecutive_planting')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\Textarea::make('warning_message')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('recovery_recommendation')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('max_consecutive_planting')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('recovery_recommendation')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommodities::route('/'),
            'create' => Pages\CreateCommodity::route('/create'),
            'edit' => Pages\EditCommodity::route('/{record}/edit'),
        ];
    }
}