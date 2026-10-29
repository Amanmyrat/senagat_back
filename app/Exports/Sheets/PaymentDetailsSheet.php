<?php

namespace App\Exports\Sheets;

use App\Exports\PaymentSheetStyle;
use App\Models\PaymentRequest;
use App\Services\PaymentReportService;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithFreezePane;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTabColor;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentDetailsSheet implements FromQuery, WithColumnWidths, WithEvents, WithFreezePane, WithHeadings, WithMapping, WithTabColor, WithTitle
{
    /**
     * @param  array{from?: mixed, to?: mixed, types?: mixed, statuses?: mixed}  $filters
     */
    public function __construct(private readonly array $filters) {}

    public function title(): string
    {
        return __('resource.payment_report_sheet_details');
    }

    public function tabColor(): string
    {
        return 'B45309';
    }

    public function freezePane(): string
    {
        return 'A2';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C' => 20,
            'D' => 18,
            'E' => 20,
            'F' => 16,
            'G' => 24,
            'H' => 16,
            'I' => 28,
            'J' => 28,
            'K' => 14,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            __('resource.date'),
            __('resource.type'),
            __('resource.status'),
            __('resource.payment_status'),
            __('resource.amount').' ('.PaymentReportService::CURRENCY.')',
            __('resource.user'),
            __('resource.phone'),
            __('resource.target'),
            __('resource.order_id'),
            __('resource.related_id'),
        ];
    }

    public function query(): Builder
    {
        return app(PaymentReportService::class)->detailQuery($this->filters);
    }

    public function map(mixed $row): array
    {
        /** @var PaymentRequest $row */
        $cents = $row->getRawOriginal('amount');

        return [
            $row->id,
            $row->created_at ? Date::dateTimeToExcel($row->created_at) : null,
            PaymentReportService::typeLabel((string) $row->type),
            PaymentReportService::statusLabel($row->status),
            PaymentReportService::statusLabel($row->payment_status),
            $cents === null ? 0.0 : round(((int) $cents) / 100, 2),
            $row->user?->name ?: __('resource.guest'),
            $row->user?->phone,
            PaymentReportService::targetLabel($row),
            $row->external_id,
            $row->related_id,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $this->style($event->sheet->getDelegate());
            },
        ];
    }

    private function style(Worksheet $sheet): void
    {
        $lastRow = $sheet->getHighestRow();
        $header = $sheet->getStyle('A1:K1');
        $header->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => PaymentSheetStyle::NAVY],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(24);

        if ($lastRow < 2) {
            $sheet->setCellValue('A2', __('resource.no_payments'));
            $sheet->mergeCells('A2:K2');
            PaymentSheetStyle::printSetup($sheet);

            return;
        }

        $sheet->setAutoFilter('A1:K'.$lastRow);
        $sheet->getStyle('B2:B'.$lastRow)->getNumberFormat()->setFormatCode('yyyy-mm-dd hh:mm');
        $sheet->getStyle('F2:F'.$lastRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->getStyle('A2:K'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => PaymentSheetStyle::LINE],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $zebra = new Conditional;
        $zebra->setConditionType(Conditional::CONDITION_EXPRESSION);
        $zebra->addCondition('MOD(ROW(),2)=0');
        $zebra->getStyle()->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB(PaymentSheetStyle::ZEBRA);
        $sheet->getStyle('A2:K'.$lastRow)->setConditionalStyles([$zebra]);

        $totalRow = $lastRow + 1;
        $sheet->setCellValue('A'.$totalRow, __('resource.total'));
        $sheet->setCellValue('F'.$totalRow, '=SUM(F2:F'.$lastRow.')');
        $sheet->getStyle('A'.$totalRow.':K'.$totalRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => PaymentSheetStyle::SECTION],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => PaymentSheetStyle::LINE],
                ],
            ],
        ]);
        $sheet->getStyle('F'.$totalRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        PaymentSheetStyle::printSetup($sheet);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
    }
}
