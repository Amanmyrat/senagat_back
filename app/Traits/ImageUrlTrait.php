<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageUrlTrait
{
    protected function imageUrl(?string $path): ?string
    {
        return $path ? Storage::disk('public')->url($path) : null;
    }
}
