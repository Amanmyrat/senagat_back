<?php
namespace App\Http\Controllers;

use App\Models\CardOrder;
use App\Models\CertificateOrder;
use App\Models\CreditApplication;
use App\Models\User;
use App\Models\UserProfile;
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
    public function certificate($id)
    {
        $record = CertificateOrder::with(['user','certificateType','branch'])->findOrFail($id);

        return view('certificate-orders.view-certificate-order', ['record' => $record]);
    }
    public function profile($id)
    {
        $record = User::with(['profile'])->findOrFail($id);

        return view('profile.profile', compact('record'));
    }
    public function pendingProfile($id)
    {
        $record = UserProfile::with(['user'])->findOrFail($id);

        return view('profile.pendingProfile', compact('record'));
    }

}

