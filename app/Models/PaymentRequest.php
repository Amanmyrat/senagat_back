<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $type
 * @property string|null $external_id
 * @property string $status
 * @property float $amount
 * @property array<array-key, mixed>|null $payment_target
 * @property array<array-key, mixed>|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string|null $target_phone
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest wherePaymentTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentRequest whereUserId($value)
 * @mixin \Eloquent
 */
class PaymentRequest extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'external_id',
        'status',
        'payment_target',
        'meta',
        'amount',
    ];

    protected $casts = [
        'payment_target' => 'array',
        'meta' => 'array',
        'amount' => MoneyCast::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTargetPhoneAttribute(): ?string
    {
        return $this->payment_target['value'] ?? null;
    }
}
