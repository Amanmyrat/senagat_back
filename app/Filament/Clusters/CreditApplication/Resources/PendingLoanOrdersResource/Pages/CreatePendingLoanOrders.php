<?php

namespace App\Filament\Clusters\CreditApplication\Resources\PendingLoanOrdersResource\Pages;

use App\Filament\Clusters\CreditApplication\Resources\PendingLoanOrdersResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePendingLoanOrders extends CreateRecord
{
    protected static string $resource = PendingLoanOrdersResource::class;
}
