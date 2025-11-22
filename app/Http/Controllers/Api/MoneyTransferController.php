<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MoneyTransferDetailsResource;
use App\Http\Resources\MoneyTransferResource;
use App\Models\MoneyTransfer;
use Illuminate\Http\JsonResponse;

class MoneyTransferController extends Controller
{
    /**
     * Money Transfers
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $moneyTransfers = MoneyTransfer::orderBy('sort')->get();

        return new JsonResponse([
            'success' => true,
            'data' => MoneyTransferResource::collection($moneyTransfers),
        ], 200);
    }

    /**
     * Money Transfer Details
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function show($id): JsonResponse
    {
        $moneyTransfer = MoneyTransfer::find($id);

        if (! $moneyTransfer) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Money transfer not found',
            ], 404);
        }

        return new JsonResponse([
            'success' => true,
            'data' => new MoneyTransferDetailsResource($moneyTransfer),
        ], 200);
    }
}
