<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateFormatTrait
{
    protected function formatDateLocalized($date): ?string
    {
        if (!$date) {
            return null;
        }

        $carbon = Carbon::parse($date)->locale(app()->getLocale());

        return $carbon->translatedFormat('d F, H:i');
    }
}
