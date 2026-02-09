<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageUrlTrait
{
    protected function imageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $url = Storage::disk('public')->url($path);

        return parse_url($url, PHP_URL_PATH);
    }

    //        return $path ? Storage::disk('public')->url($path) : null;

}
