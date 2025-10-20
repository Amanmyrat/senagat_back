<?php

namespace App\Filament\Clusters\CreditApplication\Resources\ApprovedLoanOrdersResource\Pages;

use App\Filament\Clusters\CreditApplication\Resources\ApprovedLoanOrdersResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApprovedLoanOrders extends CreateRecord
{
    protected static string $resource = ApprovedLoanOrdersResource::class;
}
