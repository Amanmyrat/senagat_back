<?php

namespace App\Filament\Resources\AuditReportResource\Pages;

use App\Filament\Resources\AuditReportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAuditReport extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = AuditReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
