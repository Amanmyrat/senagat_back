<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property string|null $image_url
 */
class DepositType extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['title', 'description', 'advantages', 'details'];

    protected $fillable = ['title', 'description', 'image_url', 'background_color', 'advantages', 'details'];

    protected $casts = [
        'advantages' => 'array',
        'details' => 'array',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(): ?string
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }
}
