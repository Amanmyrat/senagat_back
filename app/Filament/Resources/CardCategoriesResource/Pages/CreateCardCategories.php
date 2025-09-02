<?php

namespace App\Filament\Resources\CardCategoriesResource\Pages;

use App\Filament\Resources\CardCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCardCategories extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected static string $resource = CardCategoriesResource::class;
}
