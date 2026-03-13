<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profile_id
 * @property int $credit_id
 * @property $term
 * @property $amount
 * @property $interest
 * @property $monthly_payment
 * @property string|null $role
 * @property string|null $patent_number
 * @property string|null $registration_number
 * @property string|null $work_address
 * @property string|null $workplace
 * @property string|null $position
 * @property string|null $manager_work_address
 * @property $salary
 * @property int $bank_branch_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location $branch
 * @property-read \App\Models\CreditType $credit
 * @property-read \App\Models\UserProfile $profile
 * @property-read \App\Models\User $user
 * @method static Builder<static>|RejectedLoanOrder newModelQuery()
 * @method static Builder<static>|RejectedLoanOrder newQuery()
 * @method static Builder<static>|RejectedLoanOrder query()
 * @method static Builder<static>|RejectedLoanOrder whereAmount($value)
 * @method static Builder<static>|RejectedLoanOrder whereBankBranchId($value)
 * @method static Builder<static>|RejectedLoanOrder whereCreatedAt($value)
 * @method static Builder<static>|RejectedLoanOrder whereCreditId($value)
 * @method static Builder<static>|RejectedLoanOrder whereId($value)
 * @method static Builder<static>|RejectedLoanOrder whereInterest($value)
 * @method static Builder<static>|RejectedLoanOrder whereManagerWorkAddress($value)
 * @method static Builder<static>|RejectedLoanOrder whereMonthlyPayment($value)
 * @method static Builder<static>|RejectedLoanOrder wherePatentNumber($value)
 * @method static Builder<static>|RejectedLoanOrder wherePosition($value)
 * @method static Builder<static>|RejectedLoanOrder whereProfileId($value)
 * @method static Builder<static>|RejectedLoanOrder whereRegistrationNumber($value)
 * @method static Builder<static>|RejectedLoanOrder whereRole($value)
 * @method static Builder<static>|RejectedLoanOrder whereSalary($value)
 * @method static Builder<static>|RejectedLoanOrder whereStatus($value)
 * @method static Builder<static>|RejectedLoanOrder whereTerm($value)
 * @method static Builder<static>|RejectedLoanOrder whereUpdatedAt($value)
 * @method static Builder<static>|RejectedLoanOrder whereUserId($value)
 * @method static Builder<static>|RejectedLoanOrder whereWorkAddress($value)
 * @method static Builder<static>|RejectedLoanOrder whereWorkplace($value)
 * @mixin \Eloquent
 */
class RejectedLoanOrder extends CreditApplication
{
    protected $table = 'credit_applications';

    protected static function booted()
    {
        static::addGlobalScope('rejected', function (Builder $builder) {
            $builder->where('status', 'rejected');
        });
    }
}
