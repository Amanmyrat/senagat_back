<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $name
 * @property array<array-key, mixed> $description
 * @property string|null $image_url
 * @property array<array-key, mixed>|null $requirements
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereMaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereMinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CreditType extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'description', 'requirements'];

    protected $fillable = ['name', 'description', 'term', 'min_amount', 'max_amount', 'interest', 'requirements'];

    protected $casts = [
        'requirements' => 'array',
        'advantages' => 'array',
        'term' => MoneyCast::class,
        'min_amount' => MoneyCast::class,
        'max_amount' => MoneyCast::class,
        'interest' => MoneyCast::class,
    ];
}
