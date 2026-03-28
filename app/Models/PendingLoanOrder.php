<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profile_id
 * @property int $credit_id
 * @property $term
 * @property float $amount
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
 * @method static Builder<static>|PendingLoanOrder newModelQuery()
 * @method static Builder<static>|PendingLoanOrder newQuery()
 * @method static Builder<static>|PendingLoanOrder query()
 * @method static Builder<static>|PendingLoanOrder whereAmount($value)
 * @method static Builder<static>|PendingLoanOrder whereBankBranchId($value)
 * @method static Builder<static>|PendingLoanOrder whereCreatedAt($value)
 * @method static Builder<static>|PendingLoanOrder whereCreditId($value)
 * @method static Builder<static>|PendingLoanOrder whereId($value)
 * @method static Builder<static>|PendingLoanOrder whereInterest($value)
 * @method static Builder<static>|PendingLoanOrder whereManagerWorkAddress($value)
 * @method static Builder<static>|PendingLoanOrder whereMonthlyPayment($value)
 * @method static Builder<static>|PendingLoanOrder wherePatentNumber($value)
 * @method static Builder<static>|PendingLoanOrder wherePosition($value)
 * @method static Builder<static>|PendingLoanOrder whereProfileId($value)
 * @method static Builder<static>|PendingLoanOrder whereRegistrationNumber($value)
 * @method static Builder<static>|PendingLoanOrder whereRole($value)
 * @method static Builder<static>|PendingLoanOrder whereSalary($value)
 * @method static Builder<static>|PendingLoanOrder whereStatus($value)
 * @method static Builder<static>|PendingLoanOrder whereTerm($value)
 * @method static Builder<static>|PendingLoanOrder whereUpdatedAt($value)
 * @method static Builder<static>|PendingLoanOrder whereUserId($value)
 * @method static Builder<static>|PendingLoanOrder whereWorkAddress($value)
 * @method static Builder<static>|PendingLoanOrder whereWorkplace($value)
 * @property string|null $salary_document
 * @property string|null $profit_document
 * @property array<array-key, mixed>|null $rejection_reasons
 * @method static Builder<static>|PendingLoanOrder whereProfitDocument($value)
 * @method static Builder<static>|PendingLoanOrder whereRejectionReasons($value)
 * @method static Builder<static>|PendingLoanOrder whereSalaryDocument($value)
 * @mixin \Eloquent
 */
class PendingLoanOrder extends CreditApplication
{
    protected $table = 'credit_applications';

    protected static function booted()
    {
        static::addGlobalScope('pending', function (Builder $builder) {
            $builder->where('status', 'pending');
        });
    }
}
