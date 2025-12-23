<?php

namespace App\Filament\Resources\InternationalPaymentTypeResource\Pages;

use App\Filament\Resources\InternationalPaymentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInternationalPaymentTypes extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = InternationalPaymentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
