<?php

namespace App\Filament\Admin\Resources\HamaResource\Pages;

use App\Filament\Admin\Resources\HamaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHamas extends ListRecords
{
    protected static string $resource = HamaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
