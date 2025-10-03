<?php

namespace App\Filament\Resources\CreditTypesResource\Pages;

use App\Filament\Resources\CreditTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCreditTypes extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected static string $resource = CreditTypesResource::class;
}
