<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCreditStep1Request;
use App\Http\Requests\StoreCreditStep2Request;
use App\Http\Requests\StoreCreditStep3Request;
use App\Http\Resources\SubmitBranchInfoResource;
use App\Http\Resources\SubmitCreditDetailsResource;
use App\Http\Resources\SubmitWorkInfoResource;
use App\Services\CreditApplicationService;
use Illuminate\Http\JsonResponse;

class CreditApplicationController extends Controller
{
    protected $service;

    public function __construct(CreditApplicationService $service)
    {
        $this->service = $service;
    }

    /**
     * Submit Credit Details
     */
    public function submitCreditDetails(StoreCreditStep1Request $request)
    {
        $application = $this->service->saveStep($request->validated(), $request->user());

        return response()->json([
            'message' => 'Submit Credit Details ',
            'data' => collect((new SubmitCreditDetailsResource($application))->toArray($request))->except('status'),
        ], 201);

    }

    /**
     * Submit Work Info
     */
    public function submitWorkInfo(StoreCreditStep2Request $request)
    {
        $application = $this->service->saveStep($request->validated(), $request->user());

        return response()->json([
            'message' => 'Submit Work Information',
            'data' => new SubmitWorkInfoResource($application),
        ]);
    }

    /**
     * Submit Branch Info
     */
    public function submitBranchInfo(StoreCreditStep3Request $request)
    {
        $this->service->saveStep($request->validated(), $request->user());
        $application = $this->service->getPending($request->user());

        return new JsonResponse([
            'message' => 'Application submitted',
            'data' => new SubmitBranchInfoResource($application),
        ]);
    }
}
