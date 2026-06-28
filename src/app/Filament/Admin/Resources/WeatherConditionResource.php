<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\WeatherConditionResource\Pages;
use App\Filament\Admin\Resources\WeatherConditionResource\RelationManagers;
use App\Models\WeatherCondition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WeatherConditionResource extends Resource
{
    protected static ?string $model = WeatherCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Kondisi Cuaca')
                ->placeholder('Contoh: Hujan, Panas, Lembap')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('Deskripsi')
                ->placeholder('Contoh: Kondisi cuaca dengan curah hujan tinggi.')
                ->rows(3)
                ->columnSpanFull(),

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
                ->label('Nama Kondisi Cuaca')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('description')
                ->label('Deskripsi')
                ->limit(80)
                ->wrap(),

            Tables\Columns\IconColumn::make('is_active')
                ->label('Status Aktif')
                ->boolean(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime('d M Y H:i')
                ->sortable(),
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
            'index' => Pages\ListWeatherConditions::route('/'),
            'create' => Pages\CreateWeatherCondition::route('/create'),
            'edit' => Pages\EditWeatherCondition::route('/{record}/edit'),
        ];
    }
}
