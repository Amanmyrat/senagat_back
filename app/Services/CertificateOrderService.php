<?php

namespace App\Services;

use App\Models\CertificateOrder;
use App\Models\UserProfile;

class CertificateOrderService
{
    public function create(array $data, $user): CertificateOrder
    {
        $profile = UserProfile::where('user_id', $user->id)->firstOrFail();

        return CertificateOrder::create([
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'certificate_type_id' => $data['certificate_type_id'],
            'phone_number' => $data['phone_number'],
            'home_address' => $data['home_address'] ?? null,
            'bank_branch_id' => $data['bank_branch_id'] ?? null,
            'status' => 'pending',
        ]);
    }

    public function getPending($user)
    {
        return CertificateOrder::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();
    }
}
