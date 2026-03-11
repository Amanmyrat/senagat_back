<?php

namespace App\Filament\Resources\TelecomResource\Pages;

use App\Filament\Resources\TelecomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTelecom extends EditRecord
{
    protected static string $resource = TelecomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
