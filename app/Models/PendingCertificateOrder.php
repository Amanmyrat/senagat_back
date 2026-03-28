<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profile_id
 * @property int $certificate_type_id
 * @property int $bank_branch_id
 * @property string $home_address
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location $branch
 * @property-read \App\Models\CertificateType $certificateType
 * @property-read \App\Models\UserProfile $profile
 * @property-read \App\Models\User $user
 * @method static Builder<static>|PendingCertificateOrder newModelQuery()
 * @method static Builder<static>|PendingCertificateOrder newQuery()
 * @method static Builder<static>|PendingCertificateOrder query()
 * @method static Builder<static>|PendingCertificateOrder whereBankBranchId($value)
 * @method static Builder<static>|PendingCertificateOrder whereCertificateTypeId($value)
 * @method static Builder<static>|PendingCertificateOrder whereCreatedAt($value)
 * @method static Builder<static>|PendingCertificateOrder whereHomeAddress($value)
 * @method static Builder<static>|PendingCertificateOrder whereId($value)
 * @method static Builder<static>|PendingCertificateOrder whereProfileId($value)
 * @method static Builder<static>|PendingCertificateOrder whereStatus($value)
 * @method static Builder<static>|PendingCertificateOrder whereUpdatedAt($value)
 * @method static Builder<static>|PendingCertificateOrder whereUserId($value)
 * @property array<array-key, mixed>|null $rejection_reasons
 * @method static Builder<static>|PendingCertificateOrder whereRejectionReasons($value)
 * @mixin \Eloquent
 */
class PendingCertificateOrder extends CertificateOrder
{
    protected $table = 'certificate_orders';

    protected static function booted()
    {
        static::addGlobalScope('pending', function (Builder $builder) {
            $builder->where('status', 'pending');
        });
    }
}
