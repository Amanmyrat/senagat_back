<?php

namespace App\Filament\Resources\ContactAddressResource\Pages;

use App\Filament\Resources\ContactAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactAddress extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected static string $resource = ContactAddressResource::class;
}
