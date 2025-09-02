<?php

namespace App\Filament\Resources\CardCategoriesResource\Pages;

use App\Filament\Resources\CardCategoriesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardCategories extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = CardCategoriesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
