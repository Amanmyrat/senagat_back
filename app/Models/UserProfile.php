<?php

namespace App\Models;

use App\Enum\UserStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property \Illuminate\Support\Carbon $birth_date
 * @property string $passport_number
 * @property string $gender
 * @property \Illuminate\Support\Carbon $issued_date
 * @property string $issued_by
 * @property string $scan_passport
 * @property UserStatus $approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereIssuedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile wherePassportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereScanPassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUserId($value)
 * @mixin \Eloquent
 */
class UserProfile extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'birth_date',
        'passport_number',
        'gender',
        'issued_date',
        'issued_by',
        'scan_passport',
        'approved',

    ];

    protected $casts = [
        'birth_date' => 'date',
        'issued_date' => 'date',
        'approved' => UserStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
