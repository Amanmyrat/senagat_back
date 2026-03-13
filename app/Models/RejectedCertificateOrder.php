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
 * @method static Builder<static>|RejectedCertificateOrder newModelQuery()
 * @method static Builder<static>|RejectedCertificateOrder newQuery()
 * @method static Builder<static>|RejectedCertificateOrder query()
 * @method static Builder<static>|RejectedCertificateOrder whereBankBranchId($value)
 * @method static Builder<static>|RejectedCertificateOrder whereCertificateTypeId($value)
 * @method static Builder<static>|RejectedCertificateOrder whereCreatedAt($value)
 * @method static Builder<static>|RejectedCertificateOrder whereHomeAddress($value)
 * @method static Builder<static>|RejectedCertificateOrder whereId($value)
 * @method static Builder<static>|RejectedCertificateOrder whereProfileId($value)
 * @method static Builder<static>|RejectedCertificateOrder whereStatus($value)
 * @method static Builder<static>|RejectedCertificateOrder whereUpdatedAt($value)
 * @method static Builder<static>|RejectedCertificateOrder whereUserId($value)
 * @mixin \Eloquent
 */
class RejectedCertificateOrder extends CertificateOrder
{
    protected $table = 'certificate_orders';

    protected static function booted()
    {
        static::addGlobalScope('rejected', function (Builder $builder) {
            $builder->where('status', 'rejected');
        });
    }
}
