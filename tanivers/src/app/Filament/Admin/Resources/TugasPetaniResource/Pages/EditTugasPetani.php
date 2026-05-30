<?php

namespace App\Filament\Admin\Resources\TugasPetaniResource\Pages;

use App\Filament\Admin\Resources\TugasPetaniResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTugasPetani extends EditRecord
{
    protected static string $resource = TugasPetaniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
