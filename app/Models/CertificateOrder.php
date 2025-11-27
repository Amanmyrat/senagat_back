<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profile_id
 * @property int $certificate_type_id
 * @property string $phone_number
 * @property string $bank_branch
 * @property string $home_address
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CertificateType $certificateType
 * @property-read \App\Models\UserProfile $profile
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder whereBankBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder whereCertificateTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder whereHomeAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateOrder whereUserId($value)
 *
 * @mixin \Eloquent
 */
class CertificateOrder extends Model
{
    protected $fillable = [
        'user_id',
        'profile_id',
        'certificate_type_id',
        'bank_branch_id',
        'home_address',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class, 'profile_id');
    }

    public function certificateType(): BelongsTo
    {
        return $this->belongsTo(CertificateType::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'bank_branch_id');
    }
}
