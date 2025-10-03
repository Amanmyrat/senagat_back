<?php

namespace App\Filament\Resources\ContactAddressResource\Pages;

use App\Filament\Resources\ContactAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactAddress extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = ContactAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),

        ];
    }
}
