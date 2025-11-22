<?php

namespace App\Filament\Resources\DepositTypeResource\Pages;

use App\Filament\Resources\DepositTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepositType extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = DepositTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
