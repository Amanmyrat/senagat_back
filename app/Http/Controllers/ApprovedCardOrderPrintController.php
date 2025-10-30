<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\ApprovedCardOrder;
////use Barryvdh\DomPDF\Facade\Pdf;
//use Illuminate\Http\Request;
//use Spatie\LaravelPdf\Facades\Pdf as SpatiePdf;
//
//class ApprovedCardOrderPrintController extends Controller
//{
//    public function generatePdf(ApprovedCardOrder $order)
//    {
////        $order->load(['profile', 'branch', 'cardType']);
////
////        $pdf = Pdf::loadView('questionnaire', [
////            'orders' => collect([$order])
////        ])
////            ->setPaper('A4', 'portrait')
////            ->setOptions([
////                'defaultFont' => 'DejaVu Sans',
////                'isHtml5ParserEnabled' => true,
////                'isRemoteEnabled' => true,
////            ]);
////
////
////
////        return $pdf->stream('approved_order_'.$order->id.'.pdf');
////    }
//        $pdf = Pdf::loadView('questionnaire', ['orders' => collect([$order])])
//            ->setPaper('A4', 'portrait')
//            ->setOptions([
//                'defaultFont' => 'serif',
//                'isHtml5ParserEnabled' => true,
//                'isRemoteEnabled' => true,
//            ]);
//        return $pdf->stream('approved_order_' . $order->id . '.pdf');
//    }
//}


namespace App\Http\Controllers;

use App\Models\ApprovedCardOrder;


class ApprovedCardOrderPrintController extends Controller
{
    public function generatePdf(ApprovedCardOrder $order)
    {
        $order->load(['profile', 'branch', 'cardType']);

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('questionnaire', ['orders' => collect([$order])])
            ->setPaper('A4', 'portrait')
            ->stream('approved_order_' . $order->id . '.pdf');
    }
}
