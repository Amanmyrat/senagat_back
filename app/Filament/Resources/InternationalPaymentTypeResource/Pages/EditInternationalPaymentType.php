<?php

namespace App\Filament\Resources\InternationalPaymentTypeResource\Pages;

use App\Filament\Resources\InternationalPaymentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInternationalPaymentType extends EditRecord
{
    protected static string $resource = InternationalPaymentTypeResource::class;

    use EditRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
