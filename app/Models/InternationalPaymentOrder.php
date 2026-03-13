<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profile_id
 * @property int $payment_type_id
 * @property int $branch_id
 * @property array<array-key, mixed>|null $uploaded_files
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location $branch
 * @property-read \App\Models\UserProfile $profile
 * @property-read \App\Models\InternationalPaymentTypes $type
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder whereUploadedFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternationalPaymentOrder whereUserId($value)
 * @mixin \Eloquent
 */
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
