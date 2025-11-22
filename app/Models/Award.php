<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property string|null $image_url
 */
class Award extends Model
{
    use HasTranslations;

    public array $translatable = [
        'title',
        'sub_title',
        'description',
    ];

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'image_url',
        'description_images',
    ];

    protected $casts = [
        'description_images' => 'array',
    ];

    protected $appends = ['image_path', 'description_image_paths'];

    public function getImagePathAttribute(): ?string
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }

    public function getDescriptionImagePathsAttribute(): ?array
    {
        if (empty($this->description_images)) {
            return null;
        }

        return array_map(fn ($img) => asset('storage/'.$img), $this->description_images);
    }
}
