<?php

namespace App\Filament\Resources\TariffCategoryResource\Pages;

use App\Filament\Resources\TariffCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTariffCategories extends ListRecords
{
    protected static string $resource = TariffCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
