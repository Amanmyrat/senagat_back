<?php

namespace App\Casts;

use App\Models\UserProfile;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PassportScansCast implements CastsAttributes
{
    /**
     * @param  array<string, mixed>  $attributes
     * @return array<int, string>
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        return UserProfile::normalizePassportPaths($value);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        $paths = array_slice(
            UserProfile::normalizePassportPaths($value),
            0,
            UserProfile::MAX_PASSPORT_SCANS
        );

        return json_encode($paths);
    }
}
