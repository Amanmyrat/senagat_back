<?php

namespace App\Filament\Resources\BeletRequestResource\Pages;

use App\Filament\Resources\BeletRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBeletRequest extends EditRecord
{
    protected static string $resource = BeletRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
