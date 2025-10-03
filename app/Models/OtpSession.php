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
 * @property string $token
 * @property string $purpose
 * @property Carbon $expires_at
 * @property bool $is_verified
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|OtpSession forPurpose(string $purpose)
 * @method static Builder<static>|OtpSession newModelQuery()
 * @method static Builder<static>|OtpSession newQuery()
 * @method static Builder<static>|OtpSession query()
 * @method static Builder<static>|OtpSession valid()
 * @method static Builder<static>|OtpSession whereCreatedAt($value)
 * @method static Builder<static>|OtpSession whereExpiresAt($value)
 * @method static Builder<static>|OtpSession whereId($value)
 * @method static Builder<static>|OtpSession whereIsVerified($value)
 * @method static Builder<static>|OtpSession wherePhone($value)
 * @method static Builder<static>|OtpSession wherePurpose($value)
 * @method static Builder<static>|OtpSession whereToken($value)
 * @method static Builder<static>|OtpSession whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OtpSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'token',
        'purpose',
        'expires_at',
        'is_verified',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', Carbon::now())
            ->where('is_verified', false);
    }

    public function scopeForPurpose($query, string $purpose)
    {
        return $query->where('purpose', $purpose);
    }
}
