<?php

namespace App\Filament\Resources\CardTypesResource\Pages;

use App\Filament\Resources\CardTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCardTypes extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = CardTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
