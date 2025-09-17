<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $requirement_group_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RequirementGroup $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RequirementItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementCategory whereRequirementGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RequirementCategory extends Model
{
    protected $fillable = ['requirement_group_id', 'name'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(RequirementGroup::class, 'requirement_group_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(RequirementItem::class, 'requirement_category_id');
    }
}
