<?php

namespace App\Filament\Resources\PendingProfileResource\Pages;

use App\Filament\Resources\PendingProfileResource;
use Filament\Resources\Pages\EditRecord;

class EditPendingProfile extends EditRecord
{
    protected static string $resource = PendingProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
