<?php

namespace App\Filament\Resources\TariffCategoryResource\Pages;

use App\Filament\Resources\TariffCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTariffCategory extends EditRecord
{
    protected static string $resource = TariffCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
