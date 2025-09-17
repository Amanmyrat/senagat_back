<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $requirement_category_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RequirementCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementItem whereRequirementCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RequirementItem extends Model
{
    protected $fillable = ['requirement_category_id', 'name'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(RequirementCategory::class, 'requirement_category_id');
    }
}
