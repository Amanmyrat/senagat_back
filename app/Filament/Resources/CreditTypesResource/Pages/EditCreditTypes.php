<?php

namespace App\Filament\Resources\CreditTypesResource\Pages;

use App\Filament\Resources\CreditTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCreditTypes extends EditRecord
{
    use EditRecord\Concerns\Translatable;


    protected static string $resource = CreditTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
