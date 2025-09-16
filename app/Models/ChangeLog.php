<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $model_type
 * @property int $model_id
 * @property array<array-key, mixed> $changes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog whereChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChangeLog whereUserId($value)
 * @mixin \Eloquent
 */
class ChangeLog extends Model
{
    protected $fillable = [
        'user_id', 'model_type', 'model_id', 'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];
}
