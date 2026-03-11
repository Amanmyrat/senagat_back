<?php

namespace App\Filament\Resources\AstuRequestResource\Pages;

use App\Filament\Resources\AstuRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAstuRequest extends EditRecord
{
    protected static string $resource = AstuRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
