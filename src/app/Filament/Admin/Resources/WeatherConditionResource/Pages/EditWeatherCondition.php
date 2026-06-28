<?php

namespace App\Filament\Admin\Resources\WeatherConditionResource\Pages;

use App\Filament\Admin\Resources\WeatherConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeatherCondition extends EditRecord
{
    protected static string $resource = WeatherConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
