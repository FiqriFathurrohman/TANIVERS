<?php

namespace App\Filament\Admin\Resources\SoilTypeResource\Pages;

use App\Filament\Admin\Resources\SoilTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoilTypes extends ListRecords
{
    protected static string $resource = SoilTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
