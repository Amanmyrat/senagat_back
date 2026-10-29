<?php

namespace App\Exports\Sheets;

use App\Exports\PaymentSheetStyle;
use App\Services\PaymentReportService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTabColor;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentSummarySheet implements FromArray, WithColumnWidths, WithEvents, WithTabColor, WithTitle
{
    /**
     * @param  array<string, mixed>  $summary
     */
    public function __construct(private readonly array $summary) {}

    /**
     * @var array{rows: array<int, array<int, mixed>>, sections: array<int, array<string, mixed>>}|null
     */
    private ?array $layout = null;

    public function title(): string
    {
        return __('resource.payment_report_sheet_summary');
    }

    public function tabColor(): string
    {
        return PaymentSheetStyle::NAVY;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 36,
            'B' => 28,
            'C' => 22,
            'D' => 14,
        ];
    }

    public function array(): array
    {
        return $this->layout()['rows'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $this->style($event->sheet->getDelegate());
            },
        ];
    }

    /**
     * @return array{rows: array<int, array<int, mixed>>, sections: array<int, array<string, mixed>>}
     */
    private function layout(): array
    {
        if ($this->layout !== null) {
            return $this->layout;
        }

        $summary = $this->summary;
        $currency = PaymentReportService::CURRENCY;

        $rows = [
            [__('resource.payment_report')],
            ['Senagat Bank'],
            [null],
            [__('resource.generated_at'), now()->format('Y-m-d H:i')],
            [__('resource.period'), $summary['from'].' — '.$summary['to']],
            [__('resource.currency'), $currency],
            [__('resource.type'), $summary['type_label']],
            [__('resource.status'), $summary['status_label']],
            [null],
            [__('resource.overview')],
            [__('resource.payments_count'), $summary['count']],
            [__('resource.total_amount').' ('.$currency.')', $summary['amount']],
            [__('resource.confirmed').' ('.__('resource.status').')', $summary['confirmed_amount']],
            [__('resource.failed').' ('.__('resource.status').')', $summary['failed_amount']],
            [__('resource.average_amount').' ('.$currency.')', $summary['average']],
        ];

        $headings = [
            __('resource.status'),
            __('resource.count'),
            __('resource.amount').' ('.$currency.')',
            __('resource.share'),
        ];

        $sections = [
            $this->appendTable($rows, __('resource.by_status'), $headings, $summary['by_status']),
            $this->appendTable($rows, __('resource.by_payment_status'), [
                __('resource.payment_status'),
                __('resource.count'),
                __('resource.amount').' ('.$currency.')',
                __('resource.share'),
            ], $summary['by_payment_status']),
            $this->appendTable($rows, __('resource.by_type'), [
                __('resource.type'),
                __('resource.count'),
                __('resource.amount').' ('.$currency.')',
                __('resource.share'),
            ], $summary['by_type']),
            $this->appendTable($rows, __('resource.by_day'), [
                __('resource.date'),
                __('resource.count'),
                __('resource.amount').' ('.$currency.')',
                __('resource.share'),
            ], $summary['by_day']),
        ];

        return $this->layout = [
            'rows' => $rows,
            'sections' => $sections,
        ];
    }

    /**
     * @param  array<int, array<int, mixed>>  $rows
     * @param  array<int, string>  $headings
     * @param  array<int, array{label: string, count: int, amount: float, share: float}>  $records
     * @return array{title: int, header: int, start: int, end: int, empty: bool}
     */
    private function appendTable(array &$rows, string $title, array $headings, array $records): array
    {
        $rows[] = [null];
        $rows[] = [$title];
        $titleRow = count($rows);

        $rows[] = $headings;
        $headerRow = count($rows);

        if ($records === []) {
            $rows[] = [__('resource.no_payments')];

            return [
                'title' => $titleRow,
                'header' => $headerRow,
                'start' => count($rows),
                'end' => count($rows),
                'empty' => true,
            ];
        }

        foreach ($records as $record) {
            $rows[] = [
                $record['label'],
                $record['count'],
                $record['amount'],
                $record['share'],
            ];
        }

        return [
            'title' => $titleRow,
            'header' => $headerRow,
            'start' => $headerRow + 1,
            'end' => count($rows),
            'empty' => false,
        ];
    }

    private function style(Worksheet $sheet): void
    {
        $layout = $this->layout();

        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A10:D10');
        $sheet->getRowDimension(1)->setRowHeight(28);

        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
                'color' => ['rgb' => PaymentSheetStyle::NAVY],
            ],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'size' => 12,
                'color' => ['rgb' => PaymentSheetStyle::MUTED],
            ],
        ]);

        $sheet->getStyle('A4:A8')->getFont()->setBold(true);
        $sheet->getStyle('B7:B8')->getAlignment()->setWrapText(true);

        $sheet->getStyle('A10:D10')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => PaymentSheetStyle::NAVY],
            ],
        ]);

        $sheet->getStyle('A11:B15')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => PaymentSheetStyle::LINE],
                ],
            ],
        ]);
        $sheet->getStyle('A11:A15')->getFont()->setBold(true);
        $sheet->getStyle('B12:B15')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->getStyle('B11:B15')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        foreach ($layout['sections'] as $section) {
            $sheet->mergeCells('A'.$section['title'].':D'.$section['title']);
            $sheet->getStyle('A'.$section['title'].':D'.$section['title'])->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => PaymentSheetStyle::NAVY],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => PaymentSheetStyle::SECTION],
                ],
            ]);

            $sheet->getStyle('A'.$section['header'].':D'.$section['header'])->applyFromArray([
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
                ],
            ]);

            $range = 'A'.$section['header'].':D'.$section['end'];
            $sheet->getStyle($range)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => PaymentSheetStyle::LINE],
                    ],
                ],
            ]);

            if ($section['empty']) {
                $sheet->mergeCells('A'.$section['start'].':D'.$section['start']);

                continue;
            }

            $sheet->getStyle('B'.$section['start'].':B'.$section['end'])
                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('C'.$section['start'].':C'.$section['end'])
                ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $sheet->getStyle('D'.$section['start'].':D'.$section['end'])
                ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);
        }

        PaymentSheetStyle::printSetup($sheet);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
    }
}
