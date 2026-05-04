<?php

namespace App\Filament\Resources\ContactMailRecipientResource\Pages;

use App\Filament\Resources\ContactMailRecipientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactMailRecipient extends EditRecord
{
    protected static string $resource = ContactMailRecipientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
