<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class FormType extends Model
{
    use HasTranslations;

    public array $translatable = ['title'];

    protected $fillable = ['title', 'price'];
}
