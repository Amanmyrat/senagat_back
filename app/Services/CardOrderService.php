<?php

namespace App\Services;

use App\Models\CardOrder;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;


class CardOrderService
{
    public function createStep1(array $data, $user): CardOrder
    {
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        return DB::transaction(function () use ($data, $user, $profile) {
            return CardOrder::create([
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'card_type_id' => $data['card_type_id'],
                'phone_number' => $data['phone_number'],
                'bank_branch_id' => $data['bank_branch_id'],
                'status' => 'draft',
                'expires_at' => now()->addDays(3),
            ]);
        });
    }
    public function completeStep2(CardOrder $order, array $data): CardOrder
    {
        $order->update([
            'current_address' => $data['current_address'],
            'work_position' => $data['work_position'] ?? 'jobless',
            'work_phone' => $data['work_phone'] ?? null,
            'internet_service' => $data['internet_service'],
            'delivery' => $data['delivery'],
            'email' => $data['email'],
            'status' => 'pending',
        ]);

        return $order;
    }

    public function getPending($user)
    {
        return CardOrder::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();
    }
}
