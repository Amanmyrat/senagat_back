<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeletRequest extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'external_id',
        'status',
        'response_code',
        'response_body',
        'payment_target'
    ];
    protected $casts = [
        'payment_target' => 'array',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getPaymentValueAttribute(): ?string
    {
        return $this->payment_target['phone'] ?? null;
    }

}
