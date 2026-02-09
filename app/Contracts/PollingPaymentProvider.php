<?php

namespace App\Contracts;

interface PollingPaymentProvider
{
    public function pollStatusByOrderId(string $orderId): array;
}
