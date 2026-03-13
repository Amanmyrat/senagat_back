<?php

namespace App\Filament\Resources\TelecomResource\Pages;

use App\Filament\Resources\TelecomResource;
use Filament\Resources\Pages\ListRecords;

class ListTelecoms extends ListRecords
{
    protected static string $resource = TelecomResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
