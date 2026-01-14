<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentHistoryResource;
use Illuminate\Http\JsonResponse;

class PaymentHistoryController extends Controller
{
    /**
     * Payment History
     *

     */
    public function index()
    {
        $payments = auth()->user()
            ->paymentRequests()
   //         ->where('type', '!=', 'charity')
            ->latest()
            ->get();


        return new JsonResponse(PaymentHistoryResource::collection($payments));
    }
}
