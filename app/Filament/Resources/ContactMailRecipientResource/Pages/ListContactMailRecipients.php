<?php

namespace App\Filament\Resources\ContactMailRecipientResource\Pages;

use App\Filament\Resources\ContactMailRecipientResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactMailRecipients extends ListRecords
{
    protected static string $resource = ContactMailRecipientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
