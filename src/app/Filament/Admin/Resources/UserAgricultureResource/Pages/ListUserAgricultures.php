<?php

namespace App\Filament\Admin\Resources\UserAgricultureResource\Pages;

use App\Filament\Admin\Resources\UserAgricultureResource;
use Filament\Resources\Pages\ListRecords;

class ListUserAgricultures extends ListRecords
{
    protected static string $resource = UserAgricultureResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}