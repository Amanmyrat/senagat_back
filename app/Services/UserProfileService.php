<?php

namespace App\Services;

use App\Enum\ErrorMessage;
use App\Models\ChangeLog;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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
            throw new \Exception(ErrorMessage::USER_PROFILE_ALREADY_EXISTS->value);
        }

        $data = $this->formatDates($data);
        unset($data['scan_passport'], $data['scan_passports']);
        $data['scan_passport'] = $this->storePassportFiles($this->uploadedPassportFiles($request));
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
        unset($data['scan_passport'], $data['scan_passports']);

        $replacement = $this->replacementPassportScans($profile, $request);
        if ($replacement !== null) {
            $data['scan_passport'] = $replacement;
        }

        $data['approved'] = 'pending';
        $original = $profile->getOriginal();
        $profile->fill($data);
        $dirty = $profile->getDirty();

        if (! empty($dirty)) {
            $changes = [];
            foreach ($dirty as $field => $newValue) {
                $oldValue = $original[$field] ?? null;

                if ($field === 'scan_passport') {
                    $oldValue = UserProfile::normalizePassportPaths($oldValue);
                    $newValue = UserProfile::normalizePassportPaths($newValue);
                }

                $changes[$field] = [
                    'old' => $oldValue,
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

    /**
     * @return array<int, UploadedFile>
     */
    private function uploadedPassportFiles(Request $request): array
    {
        foreach (['scan_passports', 'scan_passport'] as $key) {
            if (! $request->hasFile($key)) {
                continue;
            }

            $files = $request->file($key);

            return array_values(is_array($files) ? $files : [$files]);
        }

        return [];
    }

    /**
     * @param  array<int, UploadedFile>  $files
     * @return array<int, string>
     */
    private function storePassportFiles(array $files): array
    {
        $paths = [];

        foreach (array_slice($files, 0, UserProfile::MAX_PASSPORT_SCANS) as $file) {
            $paths[] = $file->store('scans', 'public');
        }

        return $paths;
    }

    /**
     * @return array<int, string>|null Null keeps the files already saved on the profile.
     */
    private function replacementPassportScans(UserProfile $profile, Request $request): ?array
    {
        $files = $this->uploadedPassportFiles($request);

        if ($files === []) {
            return null;
        }

        $existing = $profile->passportScanPaths();
        $legacySingleFile = count($files) === 1
            && ! $request->hasFile('scan_passports')
            && ! is_array($request->file('scan_passport'));

        if ($legacySingleFile && count($existing) > 1 && $this->matchesAnyExisting($existing, $files[0])) {
            return null;
        }

        if ($this->passportFilesUnchanged($profile, $files)) {
            return null;
        }

        return $this->storePassportFiles($files);
    }

    /**
     * @param  array<int, string>  $existing
     */
    private function matchesAnyExisting(array $existing, UploadedFile $file): bool
    {
        $uploadedHash = md5_file($file->getRealPath());

        foreach ($existing as $path) {
            if (! Storage::disk('public')->exists($path)) {
                continue;
            }

            if (md5_file(Storage::disk('public')->path($path)) === $uploadedHash) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  array<int, UploadedFile>  $files
     */
    private function passportFilesUnchanged(UserProfile $profile, array $files): bool
    {
        $existing = $profile->passportScanPaths();

        if (count($existing) !== count($files)) {
            return false;
        }

        foreach ($files as $index => $file) {
            $path = $existing[$index] ?? null;

            if (! is_string($path) || ! Storage::disk('public')->exists($path)) {
                return false;
            }

            if (md5_file(Storage::disk('public')->path($path)) !== md5_file($file->getRealPath())) {
                return false;
            }
        }

        return true;
    }
}
