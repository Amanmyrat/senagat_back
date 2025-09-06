<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserProfileService
{
    /**
     * @throws \Exception
     */

    /**
     * Create profile for user
     */
    public function create(User $user, array $data, Request $request): UserProfile
    {
        if ($user->profile) {
            throw new \Exception('Profile already exists for this user.');
        }

        $data = $this->formatDates($data);

        if ($request->hasFile('scan_passport')) {
            $path = $request->file('scan_passport')->store('scans', 'public');
            $data['scan_passport'] = $path;
        }
        if (isset($data['approved'])) {
            $data['approved'] = 'rejected';
        }
        $profile = new UserProfile($data);
        $profile->user()->associate($user);
        $profile->save();

        return $profile;
    }

    /**
     * Update user profile
     */
    public function update(UserProfile $profile, array $data, Request $request): UserProfile
    {
        $data = $this->formatDates($data);

        if ($request->hasFile('scan_passport')) {
            $path = $request->file('scan_passport')->store('scans', 'public');
            $data['scan_passport'] = $path;
        }
        if (isset($data['approved'])) {
            $data['approved'] = 'rejected';
        }
        $profile->update($data);

        return $profile;
    }

    /**
     * Format date fields to Y-m-d
     */
    private function formatDates(array $data): array
    {
        if (isset($data['birth_date'])) {
            $data['birth_date'] = Carbon::createFromFormat('d-m-Y', $data['birth_date'])->format('Y-m-d');
        }
        if (isset($data['issued_date'])) {
            $data['issued_date'] = Carbon::createFromFormat('d-m-Y', $data['issued_date'])->format('Y-m-d');
        }

        return $data;
    }
}
