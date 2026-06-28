<?php

namespace App\Filament\Admin\Resources\PestResource\Pages;

use App\Filament\Admin\Resources\PestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPest extends EditRecord
{
    protected static string $resource = PestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
