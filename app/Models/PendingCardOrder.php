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
 * @method static Builder<static>|PendingCardOrder newModelQuery()
 * @method static Builder<static>|PendingCardOrder newQuery()
 * @method static Builder<static>|PendingCardOrder query()
 * @method static Builder<static>|PendingCardOrder whereBankBranchId($value)
 * @method static Builder<static>|PendingCardOrder whereCardTypeId($value)
 * @method static Builder<static>|PendingCardOrder whereCreatedAt($value)
 * @method static Builder<static>|PendingCardOrder whereDelivery($value)
 * @method static Builder<static>|PendingCardOrder whereEmail($value)
 * @method static Builder<static>|PendingCardOrder whereId($value)
 * @method static Builder<static>|PendingCardOrder whereInternetService($value)
 * @method static Builder<static>|PendingCardOrder whereProfileId($value)
 * @method static Builder<static>|PendingCardOrder whereSecretWord($value)
 * @method static Builder<static>|PendingCardOrder whereStatus($value)
 * @method static Builder<static>|PendingCardOrder whereUpdatedAt($value)
 * @method static Builder<static>|PendingCardOrder whereUserId($value)
 * @method static Builder<static>|PendingCardOrder whereWorkPhone($value)
 * @method static Builder<static>|PendingCardOrder whereWorkPosition($value)
 * @property array<array-key, mixed>|null $rejection_reasons
 * @method static Builder<static>|PendingCardOrder whereRejectionReasons($value)
 * @mixin \Eloquent
 */
class PendingCardOrder extends CardOrder
{
    protected $table = 'card_orders';

    protected static function booted()
    {
        static::addGlobalScope('pending', function (Builder $builder) {
            $builder->where('status', 'pending');
        });
    }
}
