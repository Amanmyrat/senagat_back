<?php

namespace App\Filament\Resources\FormTypeResource\Pages;

use App\Filament\Resources\FormTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormTypes extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = FormTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
