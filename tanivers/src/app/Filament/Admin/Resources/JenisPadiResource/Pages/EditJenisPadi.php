<?php

namespace App\Filament\Admin\Resources\JenisPadiResource\Pages;

use App\Filament\Admin\Resources\JenisPadiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisPadi extends EditRecord
{
    protected static string $resource = JenisPadiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
