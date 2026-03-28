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
 * @method static Builder<static>|ApprovedLoanOrder newModelQuery()
 * @method static Builder<static>|ApprovedLoanOrder newQuery()
 * @method static Builder<static>|ApprovedLoanOrder query()
 * @method static Builder<static>|ApprovedLoanOrder whereAmount($value)
 * @method static Builder<static>|ApprovedLoanOrder whereBankBranchId($value)
 * @method static Builder<static>|ApprovedLoanOrder whereCreatedAt($value)
 * @method static Builder<static>|ApprovedLoanOrder whereCreditId($value)
 * @method static Builder<static>|ApprovedLoanOrder whereId($value)
 * @method static Builder<static>|ApprovedLoanOrder whereInterest($value)
 * @method static Builder<static>|ApprovedLoanOrder whereManagerWorkAddress($value)
 * @method static Builder<static>|ApprovedLoanOrder whereMonthlyPayment($value)
 * @method static Builder<static>|ApprovedLoanOrder wherePatentNumber($value)
 * @method static Builder<static>|ApprovedLoanOrder wherePosition($value)
 * @method static Builder<static>|ApprovedLoanOrder whereProfileId($value)
 * @method static Builder<static>|ApprovedLoanOrder whereRegistrationNumber($value)
 * @method static Builder<static>|ApprovedLoanOrder whereRole($value)
 * @method static Builder<static>|ApprovedLoanOrder whereSalary($value)
 * @method static Builder<static>|ApprovedLoanOrder whereStatus($value)
 * @method static Builder<static>|ApprovedLoanOrder whereTerm($value)
 * @method static Builder<static>|ApprovedLoanOrder whereUpdatedAt($value)
 * @method static Builder<static>|ApprovedLoanOrder whereUserId($value)
 * @method static Builder<static>|ApprovedLoanOrder whereWorkAddress($value)
 * @method static Builder<static>|ApprovedLoanOrder whereWorkplace($value)
 * @property string|null $salary_document
 * @property string|null $profit_document
 * @property array<array-key, mixed>|null $rejection_reasons
 * @method static Builder<static>|ApprovedLoanOrder whereProfitDocument($value)
 * @method static Builder<static>|ApprovedLoanOrder whereRejectionReasons($value)
 * @method static Builder<static>|ApprovedLoanOrder whereSalaryDocument($value)
 * @mixin \Eloquent
 */
class ApprovedLoanOrder extends CreditApplication
{
    protected $table = 'credit_applications';

    protected static function booted()
    {
        static::addGlobalScope('approved', function (Builder $builder) {
            $builder->where('status', 'approved');
        });
    }
}
