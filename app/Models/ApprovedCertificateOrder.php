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
 * @method static Builder<static>|ApprovedCertificateOrder newModelQuery()
 * @method static Builder<static>|ApprovedCertificateOrder newQuery()
 * @method static Builder<static>|ApprovedCertificateOrder query()
 * @method static Builder<static>|ApprovedCertificateOrder whereBankBranchId($value)
 * @method static Builder<static>|ApprovedCertificateOrder whereCertificateTypeId($value)
 * @method static Builder<static>|ApprovedCertificateOrder whereCreatedAt($value)
 * @method static Builder<static>|ApprovedCertificateOrder whereHomeAddress($value)
 * @method static Builder<static>|ApprovedCertificateOrder whereId($value)
 * @method static Builder<static>|ApprovedCertificateOrder whereProfileId($value)
 * @method static Builder<static>|ApprovedCertificateOrder whereStatus($value)
 * @method static Builder<static>|ApprovedCertificateOrder whereUpdatedAt($value)
 * @method static Builder<static>|ApprovedCertificateOrder whereUserId($value)
 * @mixin \Eloquent
 */
class ApprovedCertificateOrder extends CertificateOrder
{
    protected $table = 'certificate_orders';

    protected static function booted()
    {
        static::addGlobalScope('approved', function (Builder $builder) {
            $builder->where('status', 'approved');
        });
    }
}
