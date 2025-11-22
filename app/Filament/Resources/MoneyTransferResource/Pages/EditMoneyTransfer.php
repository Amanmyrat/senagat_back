<?php

namespace App\Filament\Resources\MoneyTransferResource\Pages;

use App\Filament\Resources\MoneyTransferResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMoneyTransfer extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = MoneyTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
