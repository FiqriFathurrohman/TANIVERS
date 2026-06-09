<?php

namespace App\Filament\Admin\Resources\WeatherConditionResource\Pages;

use App\Filament\Admin\Resources\WeatherConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWeatherConditions extends ListRecords
{
    protected static string $resource = WeatherConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
