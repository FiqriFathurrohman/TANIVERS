<?php

namespace App\Filament\Admin\Resources\PlantingGuideResource\Pages;

use App\Filament\Admin\Resources\PlantingGuideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlantingGuides extends ListRecords
{
    protected static string $resource = PlantingGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Panduan Masa Tanam'),
        ];
    }
}