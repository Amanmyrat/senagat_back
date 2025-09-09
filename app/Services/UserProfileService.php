<?php

namespace App\Services;

use App\Models\ChangeLog;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data['approved'] = 'pending';
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
            $uploadedFile = $request->file('scan_passport');

            if ($profile->scan_passport && Storage::disk('public')->exists($profile->scan_passport)) {
                $oldHash = md5_file(Storage::disk('public')->path($profile->scan_passport));
                $newHash = md5_file($uploadedFile->getRealPath());
                if ($oldHash === $newHash) {
                    $data['scan_passport'] = $profile->scan_passport;
                } else {
                    $path = $uploadedFile->store('scans', 'public');
                    $data['scan_passport'] = $path;
                }
            } else {

                $path = $uploadedFile->store('scans', 'public');
                $data['scan_passport'] = $path;
            }
        } else {
            $data['scan_passport'] = $profile->scan_passport;
        }

        $data['approved'] = 'pending';
        $original = $profile->getOriginal();
        $profile->fill($data);
        $dirty = $profile->getDirty();

        if (! empty($dirty)) {
            $changes = [];
            foreach ($dirty as $field => $newValue) {
                $changes[$field] = [
                    'old' => $original[$field] ?? null,
                    'new' => $newValue,
                ];

            }
            ChangeLog::create([
                'model_type' => UserProfile::class,
                'model_id' => $profile->id,
                'changes' => $changes,
                'user_id' => auth()->id(),
            ]);
        }

        $profile->save();

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
