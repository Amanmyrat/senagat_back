<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\CreditApplication;
use App\Models\CreditType;

class CreditApplicationService
{
    /**
     * Create a new credit application (single-step)
     */
    public function createLoanOrder(array $data, $user): CreditApplication
    {
        if (! $user->profile) {
            throw new \Exception(ErrorMessage::USER_PROFILE_REQUIRED->value);
        }

        $credit = CreditType::findOrFail($data['credit_id']);
        $data['interest'] = $credit->interest;
        $data['status'] = 'pending';

        return CreditApplication::create(array_merge($data, [
            'user_id' => $user->id,
            'profile_id' => $user->profile->id,
        ]));
    }

    /**
     * Get pending application for user
     */
    public function getPending($user): CreditApplication
    {
        return $user->applications()
            ->where('status', 'pending')
            ->latest()
            ->firstOrFail();
    }
}
