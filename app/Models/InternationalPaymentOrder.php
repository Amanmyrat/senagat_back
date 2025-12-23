<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternationalPaymentOrder extends Model
{
    protected $fillable = [
        'user_id',
        'profile_id',
        'payment_type_id',
        'branch_id',
        'uploaded_files',
    ];

    protected $casts = [
        'uploaded_files' => 'array',
    ];

    public function type()
    {
        return $this->belongsTo(InternationalPaymentTypes::class, 'payment_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class, 'profile_id');
    }

    public function branch()
    {
        return $this->belongsTo(Location::class, 'branch_id');
    }
}
