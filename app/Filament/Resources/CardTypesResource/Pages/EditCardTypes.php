<?php

namespace App\Filament\Resources\CardTypesResource\Pages;

use App\Filament\Resources\CardTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardTypes extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = CardTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
