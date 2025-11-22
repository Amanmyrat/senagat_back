<?php

namespace App\Filament\Resources\MoneyTransferResource\Pages;

use App\Filament\Resources\MoneyTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMoneyTransfer extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = MoneyTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
