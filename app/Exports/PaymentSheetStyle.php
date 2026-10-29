<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentSheetStyle
{
    public const NAVY = '1B3A4B';

    public const SECTION = 'E8EEF2';

    public const ZEBRA = 'F7F9FB';

    public const MUTED = '5C6B73';

    public const LINE = 'D0D7DE';

    public static function printSetup(Worksheet $sheet): void
    {
        $setup = $sheet->getPageSetup();
        $setup->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $setup->setPaperSize(PageSetup::PAPERSIZE_A4);
        $setup->setFitToPage(true);
        $setup->setFitToWidth(1);
        $setup->setFitToHeight(0);
        $setup->setHorizontalCentered(true);

        $margins = $sheet->getPageMargins();
        $margins->setTop(0.6);
        $margins->setBottom(0.6);
        $margins->setLeft(0.5);
        $margins->setRight(0.5);
        $margins->setHeader(0.25);
        $margins->setFooter(0.25);

        $sheet->getHeaderFooter()->setOddFooter('&LSenagat Bank&C&A&R&P / &N');
        $sheet->getHeaderFooter()->setEvenFooter('&LSenagat Bank&C&A&R&P / &N');
        $sheet->setShowGridlines(false);
        $sheet->setSelectedCell('A1');
    }
}
