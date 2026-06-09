<?php

namespace App\Filament\Admin\Resources\WeatherConditionResource\Pages;

use App\Filament\Admin\Resources\WeatherConditionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWeatherCondition extends CreateRecord
{
    protected static string $resource = WeatherConditionResource::class;
}
