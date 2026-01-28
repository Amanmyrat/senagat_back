<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Services\Clients\PaymentStatusClient;
use App\Http\Controllers\Controller;

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
