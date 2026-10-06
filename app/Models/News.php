<?php

namespace App\Models;

use App\Traits\HasActiveFlag;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed> $description
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $image_url
 * @property-read mixed $translations
 *
 * @method static Builder<static>|News newModelQuery()
 * @method static Builder<static>|News newQuery()
 * @method static Builder<static>|News query()
 * @method static Builder<static>|News whereCreatedAt($value)
 * @method static Builder<static>|News whereDescription($value)
 * @method static Builder<static>|News whereId($value)
 * @method static Builder<static>|News whereImageUrl($value)
 * @method static Builder<static>|News whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|News whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|News whereLocale(string $column, string $locale)
 * @method static Builder<static>|News whereLocales(string $column, array $locales)
 * @method static Builder<static>|News wherePublishedAt($value)
 * @method static Builder<static>|News whereTitle($value)
 * @method static Builder<static>|News whereUpdatedAt($value)
 *
 * @property int|null $sort
 *
 * @method static Builder<static>|News whereSort($value)
 *
 * @mixin Eloquent
 */
class News extends Model
{
    use HasActiveFlag;
    use HasTranslations;

    public array $translatable = ['title', 'description'];

    protected $fillable = ['title', 'description', 'published_at', 'is_active'];

    protected $casts = [
        'published_at' => 'datetime',
        'types' => 'array',
        'is_active' => 'boolean',
    ];
}
