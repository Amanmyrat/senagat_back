<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profile_id
 * @property int $credit_id
 * @property int $term
 * @property string $amount
 * @property string $interest
 * @property string $monthly_payment
 * @property string|null $role
 * @property string|null $patent_number
 * @property string|null $registration_number
 * @property string|null $work_address
 * @property string|null $workplace
 * @property string|null $position
 * @property string|null $manager_work_address
 * @property string|null $phone_number
 * @property string|null $salary
 * @property string|null $country
 * @property string|null $bank_name
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CreditType $credit
 * @property-read \App\Models\UserProfile $profile
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereCreditId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereManagerWorkAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereMonthlyPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication wherePatentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereWorkAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditApplication whereWorkplace($value)
 * @mixin \Eloquent
 */
class CreditApplication extends Model
{
    protected $fillable = [
        'user_id',
        'profile_id',
        'credit_id',
        'term',
        'amount',
        'interest',
        'monthly_payment',
        'role',
        'patent_number', 'registration_number', 'work_address',
        'workplace', 'position', 'manager_work_address', 'phone_number', 'salary',
        'country', 'bank_name','status',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class, 'profile_id');
    }

    public function credit(): BelongsTo
    {
        return $this->belongsTo(CreditType::class);
    }
}
