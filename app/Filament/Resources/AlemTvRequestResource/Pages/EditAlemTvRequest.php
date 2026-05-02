<?php

namespace App\Filament\Resources\AlemTvRequestResource\Pages;

use App\Filament\Resources\AlemTvRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlemTvRequest extends EditRecord
{
    protected static string $resource = AlemTvRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
