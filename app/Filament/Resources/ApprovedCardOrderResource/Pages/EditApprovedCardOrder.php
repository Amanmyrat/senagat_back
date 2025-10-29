<?php

namespace App\Filament\Resources\ApprovedCardOrderResource\Pages;

use App\Filament\Resources\ApprovedCardOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovedCardOrder extends EditRecord
{
    protected static string $resource = ApprovedCardOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
