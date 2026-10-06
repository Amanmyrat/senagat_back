<?php

namespace App\Models;

use App\Traits\HasActiveFlag;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * @property string|null $image_url
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed>|null $sub_title
 * @property array<array-key, mixed>|null $description
 * @property array<array-key, mixed>|null $description_images
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $sort
 * @property-read array|null $description_image_paths
 * @property-read string|null $image_path
 * @property-read mixed $translations
 *
 * @method static Builder<static>|Award newModelQuery()
 * @method static Builder<static>|Award newQuery()
 * @method static Builder<static>|Award query()
 * @method static Builder<static>|Award whereCreatedAt($value)
 * @method static Builder<static>|Award whereDescription($value)
 * @method static Builder<static>|Award whereDescriptionImages($value)
 * @method static Builder<static>|Award whereId($value)
 * @method static Builder<static>|Award whereImageUrl($value)
 * @method static Builder<static>|Award whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Award whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Award whereLocale(string $column, string $locale)
 * @method static Builder<static>|Award whereLocales(string $column, array $locales)
 * @method static Builder<static>|Award whereSort($value)
 * @method static Builder<static>|Award whereSubTitle($value)
 * @method static Builder<static>|Award whereTitle($value)
 * @method static Builder<static>|Award whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Award extends Model
{
    use HasActiveFlag;
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
        'is_active',
    ];

    protected $casts = [
        'description_images' => 'array',
        'is_active' => 'boolean',
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
