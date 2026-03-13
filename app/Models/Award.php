<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property string|null $image_url
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed>|null $sub_title
 * @property array<array-key, mixed>|null $description
 * @property array<array-key, mixed>|null $description_images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $sort
 * @property-read array|null $description_image_paths
 * @property-read string|null $image_path
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereDescriptionImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Award whereUpdatedAt($value)
 * @mixin \Eloquent
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
