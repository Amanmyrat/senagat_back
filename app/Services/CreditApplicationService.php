<?php

namespace App\Services;

use App\Models\CreditApplication;

class CreditApplicationService
{
    public function saveStep(array $data, $user)
    {
        //        $lastApplication = $user->applications()->latest()->first();
        //        if ($lastApplication && !$lastApplication->submitted_at) {
        //            throw new \Exception('The user has an incomplete application.');
        //        }
        return CreditApplication::updateOrCreate(
            ['user_id' => $user->id],
            array_merge($data, [
                'user_id' => $user->id,
                'profile_id' => $user->profile?->id,
            ])
        );
    }

    public function submitDraft($user)
    {
        //        $application = $user->applications()->where('status','draft')->firstOrFail();
        //        $application->update(['status' => 'pending']);
        return $user->applications()->latest()->firstOrFail();

    }
}
