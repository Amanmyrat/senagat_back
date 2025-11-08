<?php

namespace App\Filament\Resources\TariffDetailResource\Pages;

use App\Filament\Resources\TariffDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTariffDetails extends ListRecords
{
    protected static string $resource = TariffDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
