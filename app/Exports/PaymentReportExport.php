<?php

namespace App\Exports;

use App\Exports\Sheets\PaymentDetailsSheet;
use App\Exports\Sheets\PaymentSummarySheet;
use App\Services\PaymentReportService;
use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithProperties;

class PaymentReportExport implements Export, WithMultipleSheets, WithProperties
{
    /**
     * @param  array{from?: mixed, to?: mixed, types?: mixed, statuses?: mixed}  $filters
     */
    public function __construct(private readonly array $filters) {}

    public function sheets(): array
    {
        $summary = app(PaymentReportService::class)->summarize($this->filters);

        return [
            new PaymentSummarySheet($summary),
            new PaymentDetailsSheet($this->filters),
        ];
    }

    public function properties(): array
    {
        return [
            'creator' => 'Senagat Bank',
            'lastModifiedBy' => 'Senagat Bank',
            'title' => __('resource.payment_report'),
            'subject' => __('resource.payment_report'),
            'description' => __('resource.payment_report_description'),
            'keywords' => 'payments,report',
            'category' => 'Report',
        ];
    }
}
