<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;

class UserProfileService
{
    /**
     * @throws \Exception
     */
    public function create(User $user, array $data): UserProfile
    {
        if ($user->profile) {
            throw new \Exception('Profile already exists for this user.');
        }

        /** @var UserProfile $profile */
        $profile = $user->profile()->create($data);

        return $profile;
    }

    public function update(UserProfile $profile, array $data): UserProfile
    {
        $profile->update($data);

        return $profile;
    }
}
