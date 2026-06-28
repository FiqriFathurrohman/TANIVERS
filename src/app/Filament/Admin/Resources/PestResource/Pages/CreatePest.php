<?php

namespace App\Filament\Admin\Resources\PestResource\Pages;

use App\Filament\Admin\Resources\PestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePest extends CreateRecord
{
    protected static string $resource = PestResource::class;
}
