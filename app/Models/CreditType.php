<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $name
 * @property array<array-key, mixed> $description
 * @property int $term
 * @property string $amount
 * @property string $interest
 * @property string|null $image_url
 * @property array<array-key, mixed>|null $requirements
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CreditType extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $fillable = ['name', 'description', 'term', 'amount', 'interest','requirements',];

    protected $casts = [
        'requirements' => 'array',
    ];


}
