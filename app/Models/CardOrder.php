<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profile_id
 * @property int $card_type_id
 * @property string $phone_number
 * @property string $bank_branch
 * @property string $home_phone_number
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CardType $cardType
 * @property-read \App\Models\UserProfile $profile
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereBankBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereCardTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereHomePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereUserId($value)
 * @property int $bank_branch_id
 * @property string|null $work_position
 * @property int|null $work_phone
 * @property bool $internet_service
 * @property bool $delivery
 * @property string|null $email
 * @property string|null $secret_word
 * @property-read \App\Models\Location $branch
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereBankBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereInternetService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereSecretWord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereWorkPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardOrder whereWorkPosition($value)
 * @mixin \Eloquent
 */
class CardOrder extends Model
{
    protected $fillable = [
        'user_id',
        'profile_id',
        'card_type_id',
        'bank_branch_id',
        'status',
        'secret_word',
        'work_position',
        'work_phone',
        'internet_service',
        'delivery',
        'email',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class, 'profile_id');
    }

    public function cardType(): BelongsTo
    {
        return $this->belongsTo(CardType::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'bank_branch_id', 'id');
    }
}
