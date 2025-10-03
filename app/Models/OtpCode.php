<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $phone
 * @property string $code
 * @property string|null $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|OtpCode newModelQuery()
 * @method static Builder<static>|OtpCode newQuery()
 * @method static Builder<static>|OtpCode query()
 * @method static Builder<static>|OtpCode whereCode($value)
 * @method static Builder<static>|OtpCode whereCreatedAt($value)
 * @method static Builder<static>|OtpCode whereExpiresAt($value)
 * @method static Builder<static>|OtpCode whereId($value)
 * @method static Builder<static>|OtpCode wherePhone($value)
 * @method static Builder<static>|OtpCode whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OtpCode extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'expires_at', 'phone'];

    protected $dates = ['expires_at'];
}
