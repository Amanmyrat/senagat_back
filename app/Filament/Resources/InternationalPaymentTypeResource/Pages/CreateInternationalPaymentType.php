<?php

namespace App\Filament\Resources\InternationalPaymentTypeResource\Pages;

use App\Filament\Resources\InternationalPaymentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInternationalPaymentType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected static string $resource = InternationalPaymentTypeResource::class;
}
