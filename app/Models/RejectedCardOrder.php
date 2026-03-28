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
 * @method static Builder<static>|RejectedCardOrder newModelQuery()
 * @method static Builder<static>|RejectedCardOrder newQuery()
 * @method static Builder<static>|RejectedCardOrder query()
 * @method static Builder<static>|RejectedCardOrder whereBankBranchId($value)
 * @method static Builder<static>|RejectedCardOrder whereCardTypeId($value)
 * @method static Builder<static>|RejectedCardOrder whereCreatedAt($value)
 * @method static Builder<static>|RejectedCardOrder whereDelivery($value)
 * @method static Builder<static>|RejectedCardOrder whereEmail($value)
 * @method static Builder<static>|RejectedCardOrder whereId($value)
 * @method static Builder<static>|RejectedCardOrder whereInternetService($value)
 * @method static Builder<static>|RejectedCardOrder whereProfileId($value)
 * @method static Builder<static>|RejectedCardOrder whereSecretWord($value)
 * @method static Builder<static>|RejectedCardOrder whereStatus($value)
 * @method static Builder<static>|RejectedCardOrder whereUpdatedAt($value)
 * @method static Builder<static>|RejectedCardOrder whereUserId($value)
 * @method static Builder<static>|RejectedCardOrder whereWorkPhone($value)
 * @method static Builder<static>|RejectedCardOrder whereWorkPosition($value)
 * @property array<array-key, mixed>|null $rejection_reasons
 * @method static Builder<static>|RejectedCardOrder whereRejectionReasons($value)
 * @mixin \Eloquent
 */
class RejectedCardOrder extends CardOrder
{
    protected $table = 'card_orders';

    protected static function booted()
    {
        static::addGlobalScope('rejected', function (Builder $builder) {
            $builder->where('status', 'rejected');
        });
    }
}
