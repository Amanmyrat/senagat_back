<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class InternationalPaymentTypes extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'required_files'];

    protected $fillable = ['title', 'required_files'];

    protected $casts = [
        'required_files' => 'array',
    ];
}
