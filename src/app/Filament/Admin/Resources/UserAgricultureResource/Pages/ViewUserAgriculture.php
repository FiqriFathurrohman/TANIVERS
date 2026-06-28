<?php

namespace App\Filament\Admin\Resources\UserAgricultureResource\Pages;

use App\Filament\Admin\Resources\UserAgricultureResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserAgriculture extends ViewRecord
{
    protected static string $resource = UserAgricultureResource::class;

    protected static string $view = 'user-agriculture-resource.view-user-agriculture';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kembali')
                ->label('Kembali')
                ->url(UserAgricultureResource::getUrl('index'))
                ->color('gray'),
        ];
    }
}