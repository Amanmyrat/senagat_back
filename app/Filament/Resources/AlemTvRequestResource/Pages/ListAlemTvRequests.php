<?php

namespace App\Filament\Resources\AlemTvRequestResource\Pages;

use App\Filament\Resources\AlemTvRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlemTvRequests extends ListRecords
{
    protected static string $resource = AlemTvRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
