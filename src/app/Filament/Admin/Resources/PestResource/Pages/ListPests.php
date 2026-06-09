<?php

namespace App\Filament\Admin\Resources\PestResource\Pages;

use App\Filament\Admin\Resources\PestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPests extends ListRecords
{
    protected static string $resource = PestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
