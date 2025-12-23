<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
