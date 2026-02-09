<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Clients\PaymentStatusClient;

class PaymentStatusController extends Controller
{
    protected PaymentStatusClient $statusClient;

    public function __construct(PaymentStatusClient $statusClient)
    {
        $this->statusClient = $statusClient;
    }

    /**
     * Check payment status by orderId
     */
    public function checkStatus(string $orderId)
    {

        $status = $this->statusClient->checkStatus($orderId);

        return response()->json($status);
    }
}
