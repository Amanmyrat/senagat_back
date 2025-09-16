<?php

namespace App\Filament\Resources\CreditTypesResource\Pages;

use App\Filament\Resources\CreditTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreditTypes extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = CreditTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
