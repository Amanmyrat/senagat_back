<?php

namespace App\Models;

use App\Enum\LocationType;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property LocationType $type
 * @property array<array-key, mixed> $name
 * @property array<array-key, mixed> $address
 * @property array<array-key, mixed> $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $phoneNumber
 * @property string|null $fax
 * @property string|null $homeNumber
 * @property string|null $title
 * @property array<array-key, mixed>|null $hours
 * @property-read mixed $translations
 * @method static Builder<static>|Location newModelQuery()
 * @method static Builder<static>|Location newQuery()
 * @method static Builder<static>|Location query()
 * @method static Builder<static>|Location whereAddress($value)
 * @method static Builder<static>|Location whereCreatedAt($value)
 * @method static Builder<static>|Location whereFax($value)
 * @method static Builder<static>|Location whereHomeNumber($value)
 * @method static Builder<static>|Location whereHours($value)
 * @method static Builder<static>|Location whereId($value)
 * @method static Builder<static>|Location whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Location whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Location whereLocale(string $column, string $locale)
 * @method static Builder<static>|Location whereLocales(string $column, array $locales)
 * @method static Builder<static>|Location whereLocation($value)
 * @method static Builder<static>|Location whereName($value)
 * @method static Builder<static>|Location wherePhoneNumber($value)
 * @method static Builder<static>|Location whereTitle($value)
 * @method static Builder<static>|Location whereType($value)
 * @method static Builder<static>|Location whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Location extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'address', 'hours'];

    protected $fillable = ['type', 'name', 'address', 'location', 'hours', 'phone_number', 'fax_number', 'home_number'];

    protected $casts = [
        'location' => 'array',
        'type' => LocationType::class,
    ];
}
