<?php
namespace App\Http\Controllers;

use App\Models\CardOrder;
use App\Models\CreditApplication;
use Illuminate\Http\Request;

class OrderPdfController extends Controller
{
    public function card($id)
{
    $record = CardOrder::with(['user', 'cardType', 'branch'])->findOrFail($id);

    return view('card-orders.view-card-order', ['record' => $record]);
}
    public function credit($id)
    {
        $record = CreditApplication::with(['user', 'credit', 'branch'])->findOrFail($id);

        return view('credit-orders.view-credit-order', ['record' => $record]);
    }
}

