<?php

namespace App\Filament\Resources\RejectedProfileResource\Pages;

use App\Filament\Resources\RejectedProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRejectedProfile extends EditRecord
{
    protected static string $resource = RejectedProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
