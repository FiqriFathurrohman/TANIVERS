<?php

namespace App\Filament\Admin\Resources\SoilTypeResource\Pages;

use App\Filament\Admin\Resources\SoilTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSoilType extends EditRecord
{
    protected static string $resource = SoilTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
