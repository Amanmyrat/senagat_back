<?php

namespace App\Services;

use App\Models\CreditApplication;
use App\Models\CreditType;

class CreditApplicationService
{
    public function saveStep(array $data, $user)
    {
        $application = CreditApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();
        if (isset($data['credit_id'])) {
            $credit = CreditType::findOrFail($data['credit_id']);
            $data['interest'] = $credit->interest;
        }
        $data['status'] = 'pending';
        unset($data['step']);
        if ($application) {
            $application->update($data);
        } else {
            $application = CreditApplication::create(array_merge($data, [
                'user_id' => $user->id,
                'profile_id' => $user->profile?->id,
            ]));
        }
        return $application;

    }

    public function getPending($user)
    {
        return $user->applications()->where('status', 'pending')->latest()->firstOrFail();
    }
//    public function submitDraft($user)
//    {
//        //        $application = $user->applications()->where('status','draft')->firstOrFail();
//        //        $application->update(['status' => 'pending']);
//        return $user->applications()->latest()->firstOrFail();
//
//    }
}
