<?php

namespace App\Filament\Resources\TariffDetailResource\Pages;

use App\Filament\Resources\TariffDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTariffDetail extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = TariffDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
