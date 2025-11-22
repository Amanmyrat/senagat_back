<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditReportResource;
use App\Models\AuditReport;
use Illuminate\Http\JsonResponse;

class AuditReportController extends Controller
{
    /**
     * Audit Reports
     *
     * @unauthenticated
     *
     * @localizationHeader
     */
    public function index(): JsonResponse
    {
        $auditReports = AuditReport::orderBy('created_at', 'desc')->get();

        return new JsonResponse([
            'success' => true,
            'data' => AuditReportResource::collection($auditReports),
        ], 200);
    }
}
