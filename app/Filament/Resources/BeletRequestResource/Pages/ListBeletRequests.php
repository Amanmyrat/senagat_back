<?php

namespace App\Filament\Resources\BeletRequestResource\Pages;

use App\Filament\Resources\BeletRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBeletRequests extends ListRecords
{
    protected static string $resource = BeletRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
