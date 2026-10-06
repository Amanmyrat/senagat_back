<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasActiveFlag
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where($query->qualifyColumn('is_active'), true);
    }
}
