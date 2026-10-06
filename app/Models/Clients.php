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
 *
 * @method static get()
 *
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed>|null $company_type
 * @property array<array-key, mixed>|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $sort
 * @property-read string|null $image_path
 * @property-read mixed $translations
 *
 * @method static Builder<static>|Clients newModelQuery()
 * @method static Builder<static>|Clients newQuery()
 * @method static Builder<static>|Clients query()
 * @method static Builder<static>|Clients whereCompanyType($value)
 * @method static Builder<static>|Clients whereCreatedAt($value)
 * @method static Builder<static>|Clients whereDescription($value)
 * @method static Builder<static>|Clients whereId($value)
 * @method static Builder<static>|Clients whereImageUrl($value)
 * @method static Builder<static>|Clients whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Clients whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Clients whereLocale(string $column, string $locale)
 * @method static Builder<static>|Clients whereLocales(string $column, array $locales)
 * @method static Builder<static>|Clients whereSort($value)
 * @method static Builder<static>|Clients whereTitle($value)
 * @method static Builder<static>|Clients whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Clients extends Model
{
    use HasActiveFlag;
    use HasTranslations;

    public array $translatable = ['title', 'company_type', 'description'];

    protected $fillable = [
        'title', 'company_type', 'description', 'image_url', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(): ?string
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }
}
