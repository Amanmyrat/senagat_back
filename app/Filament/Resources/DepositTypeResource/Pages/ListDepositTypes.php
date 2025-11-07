<?php

namespace App\Filament\Resources\DepositTypeResource\Pages;

use App\Filament\Resources\DepositTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepositTypes extends ListRecords
{
    use ListRecords\Concerns\Translatable;
    protected static string $resource = DepositTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
