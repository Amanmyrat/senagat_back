<?php

namespace App\Filament\Resources\TmCellRequestResource\Pages;

use App\Filament\Resources\TmCellRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTmCellRequests extends ListRecords
{
    protected static string $resource = TmCellRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
