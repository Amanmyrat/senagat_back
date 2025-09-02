<?php

namespace App\Filament\Resources\CardCategoriesResource\Pages;

use App\Filament\Resources\CardCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCardCategories extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = CardCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
