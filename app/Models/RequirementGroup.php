<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $credit_type_id
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RequirementCategory> $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\CreditType $creditType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementGroup whereCreditTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequirementGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RequirementGroup extends Model
{
    protected $fillable = ['credit_type_id', 'title'];

    public function creditType(): BelongsTo
    {
        return $this->belongsTo(CreditType::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(RequirementCategory::class);
    }
}
