<?php

namespace App\Services;

use App\Models\CardOrder;
use App\Models\CreditApplication;
use App\Models\UserProfile;

class CardOrderService
{

    public function create(array $data, $user): CardOrder
    {
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        return CardOrder::create([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'card_type_id' => $data['card_type_id'],
            'phone_number' => $data['phone_number'],
            'home_phone_number' => $data['home_phone_number'] ?? null,
            'bank_branch' => $data['bank_branch'] ?? null,
            'status' => 'pending',
        ]);
    }


    public function getPending($user)
    {
        return CardOrder::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();
    }
}

