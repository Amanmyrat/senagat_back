<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed> $address
 * @property string $phone_number
 * @property string $fax_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereFaxNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ContactAddress extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'address'];

    protected $fillable = ['title', 'address', 'phone_number', 'fax_number'];
}
