<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profile_id
 * @property int $card_type_id
 * @property int $bank_branch_id
 * @property string|null $work_position
 * @property int|null $work_phone
 * @property bool $internet_service
 * @property bool $delivery
 * @property string|null $email
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $secret_word
 * @property-read \App\Models\Location $branch
 * @property-read \App\Models\CardType $cardType
 * @property-read \App\Models\UserProfile $profile
 * @property-read \App\Models\User $user
 * @method static Builder<static>|ApprovedCardOrder newModelQuery()
 * @method static Builder<static>|ApprovedCardOrder newQuery()
 * @method static Builder<static>|ApprovedCardOrder query()
 * @method static Builder<static>|ApprovedCardOrder whereBankBranchId($value)
 * @method static Builder<static>|ApprovedCardOrder whereCardTypeId($value)
 * @method static Builder<static>|ApprovedCardOrder whereCreatedAt($value)
 * @method static Builder<static>|ApprovedCardOrder whereDelivery($value)
 * @method static Builder<static>|ApprovedCardOrder whereEmail($value)
 * @method static Builder<static>|ApprovedCardOrder whereId($value)
 * @method static Builder<static>|ApprovedCardOrder whereInternetService($value)
 * @method static Builder<static>|ApprovedCardOrder whereProfileId($value)
 * @method static Builder<static>|ApprovedCardOrder whereSecretWord($value)
 * @method static Builder<static>|ApprovedCardOrder whereStatus($value)
 * @method static Builder<static>|ApprovedCardOrder whereUpdatedAt($value)
 * @method static Builder<static>|ApprovedCardOrder whereUserId($value)
 * @method static Builder<static>|ApprovedCardOrder whereWorkPhone($value)
 * @method static Builder<static>|ApprovedCardOrder whereWorkPosition($value)
 * @mixin \Eloquent
 */
class ApprovedCardOrder extends CardOrder
{
    protected $table = 'card_orders';

    protected static function booted()
    {
        static::addGlobalScope('approved', function (Builder $builder) {
            $builder->where('status', 'approved');
        });
    }
}
