<?php

namespace App\Filament\Resources\TariffCategoryResource\Pages;

use App\Filament\Resources\TariffCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTariffCategory extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }
    protected static string $resource = TariffCategoryResource::class;
}
