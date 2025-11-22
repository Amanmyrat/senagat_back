<?php

namespace App\Filament\Resources\AwardsResource\Pages;

use App\Filament\Resources\AwardsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAwards extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),

        ];
    }

    protected static string $resource = AwardsResource::class;
}
