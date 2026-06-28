<?php

namespace App\Filament\Admin\Resources\PlantingGuideResource\Pages;

use App\Filament\Admin\Resources\PlantingGuideResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlantingGuide extends CreateRecord
{
    protected static string $resource = PlantingGuideResource::class;

    protected function beforeValidate(): void
    {
        PlantingGuideResource::validateGuideFlow($this->data ?? []);
    }
}