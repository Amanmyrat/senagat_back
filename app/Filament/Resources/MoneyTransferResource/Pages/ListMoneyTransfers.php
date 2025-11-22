<?php

namespace App\Filament\Resources\MoneyTransferResource\Pages;

use App\Filament\Resources\MoneyTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMoneyTransfers extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = MoneyTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
