<?php

namespace App\Filament\Admin\Resources\KomuditasResource\Pages;

use App\Filament\Admin\Resources\KomuditasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKomuditas extends EditRecord
{
    protected static string $resource = KomuditasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
