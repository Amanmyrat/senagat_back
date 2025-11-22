<?php

namespace App\Filament\Resources\TariffDetailResource\Pages;

use App\Filament\Resources\TariffDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTariffDetail extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected static string $resource = TariffDetailResource::class;
}
