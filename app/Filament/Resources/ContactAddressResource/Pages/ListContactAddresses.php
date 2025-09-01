<?php

namespace App\Filament\Resources\ContactAddressResource\Pages;

use App\Filament\Resources\ContactAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactAddresses extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = ContactAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
