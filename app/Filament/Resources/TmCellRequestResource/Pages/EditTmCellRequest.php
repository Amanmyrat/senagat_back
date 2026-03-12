<?php

namespace App\Filament\Resources\TmCellRequestResource\Pages;

use App\Filament\Resources\TmCellRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTmCellRequest extends EditRecord
{
    protected static string $resource = TmCellRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
