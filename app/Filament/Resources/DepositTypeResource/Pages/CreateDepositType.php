<?php

namespace App\Filament\Resources\DepositTypeResource\Pages;

use App\Filament\Resources\DepositTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDepositType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected static string $resource = DepositTypeResource::class;
}
