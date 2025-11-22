<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property string|null $image_url
 * @property string|null $background_color
 */
class MoneyTransfer extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'title',
        'sub_title',
        'main_title',
        'description',
        'advantages',
        'header_text',
        'footer_text',
        'tariff_details',
    ];

    protected $fillable = [
        'title',
        'sub_title',
        'main_title',
        'description',
        'advantages',
        'header_text',
        'footer_text',
        'tariff_details',
        'background_color',
        'image_url',
    ];

    protected $casts = [
        'advantages' => 'array',
        'tariff_details' => 'array',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(): ?string
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }
}
