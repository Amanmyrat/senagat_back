<?php
namespace App\Models\Traits;

use App\Enum\UserStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $status
 * @property array|null $rejection_reasons
 * @property bool $approved
 * @mixin Model
 */
trait ClearsRejectionReasons
{
    protected static function bootClearsRejectionReasons()
    {
        static::saving(function (Model $model) {
            if ($model->isDirty('status') && $model->status === 'approved') {
                $model->rejection_reasons = null;
            }

            if ($model->isDirty('approved') && $model->approved === UserStatus::Approved) {
                $model->rejection_reasons = null;
            }
        });
    }
}
