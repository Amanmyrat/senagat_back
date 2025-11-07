<?php

namespace App\Http\Controllers\Api;

use App\Enum\SuccessMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanOrderRequest;
use App\Http\Resources\LoanOrderResource;
use App\Services\CreditApplicationService;
use Exception;
use Illuminate\Http\JsonResponse;

class CreditApplicationController extends Controller
{
    protected $service;

    public function __construct(CreditApplicationService $service)
    {
        $this->service = $service;
    }

    /**
     * Credit Order
     */
    public function store(LoanOrderRequest $request)
    {
        try {
            $application = $this->service->createLoanOrder($request->validated(), $request->user());

            return new JsonResponse([
                'success' => true,
                'code' => SuccessMessage::LOAN_ORDER_CREATED->value,
                'data' => collect((new LoanOrderResource($application))->toArray($request))
                    ->except('status'),
            ], 201);

        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error_message' => $e->getMessage(),
            //    'code' => ErrorMessage::LOAN_ORDER_CREATION_FAILED->value,
            ], 400);
        }
    }
}
