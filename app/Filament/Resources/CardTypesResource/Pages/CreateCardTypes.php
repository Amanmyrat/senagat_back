<?php

namespace App\Filament\Resources\CardTypesResource\Pages;

use App\Filament\Resources\CardTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCardTypes extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected static string $resource = CardTypesResource::class;
}
