<?php

namespace App\Filament\Resources\CardOrderResource\Pages;

use App\Filament\Resources\CardOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCardOrder extends EditRecord
{
    protected static string $resource = CardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
