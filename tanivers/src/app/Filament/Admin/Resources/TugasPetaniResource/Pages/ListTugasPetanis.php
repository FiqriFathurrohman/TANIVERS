<?php

namespace App\Filament\Admin\Resources\TugasPetaniResource\Pages;

use App\Filament\Admin\Resources\TugasPetaniResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTugasPetanis extends ListRecords
{
    protected static string $resource = TugasPetaniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
