<?php

namespace App\Filament\Resources\AstuRequestResource\Pages;

use App\Filament\Resources\AstuRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAstuRequests extends ListRecords
{
    protected static string $resource = AstuRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
