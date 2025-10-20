<?php

namespace App\Filament\Clusters\CertificateOrder\Resources\ApprovedCertificateOrderResource\Pages;

use App\Filament\Clusters\CertificateOrder\Resources\ApprovedCertificateOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApprovedCertificateOrder extends CreateRecord
{
    protected static string $resource = ApprovedCertificateOrderResource::class;
}
