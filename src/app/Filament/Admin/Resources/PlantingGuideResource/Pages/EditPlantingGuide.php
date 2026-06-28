<?php

namespace App\Filament\Admin\Resources\PlantingGuideResource\Pages;

use App\Filament\Admin\Resources\PlantingGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlantingGuide extends EditRecord
{
    protected static string $resource = PlantingGuideResource::class;

    protected function beforeValidate(): void
    {
        PlantingGuideResource::validateGuideFlow($this->data ?? [], $this->record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}