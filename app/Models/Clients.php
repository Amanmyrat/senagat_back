<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property string|null $image_url
 * @method static get()
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed>|null $company_type
 * @property array<array-key, mixed>|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $sort
 * @property-read string|null $image_path
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereCompanyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clients whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Clients extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'company_type', 'description'];

    protected $fillable = [
        'title', 'company_type', 'description', 'image_url',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(): ?string
    {
        return $this->image_url
            ? asset('storage/'.$this->image_url)
            : null;
    }
}
