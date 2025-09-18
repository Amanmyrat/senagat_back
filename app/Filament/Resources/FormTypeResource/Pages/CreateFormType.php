<?php

namespace App\Filament\Resources\FormTypeResource\Pages;

use App\Filament\Resources\FormTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFormType extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }
    protected static string $resource = FormTypeResource::class;
}
