<?php

namespace App\Models\Traits;

use App\Enum\UserStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $status
 * @property array|null $rejection_reasons
 * @property UserStatus|string|null $approved
 * @mixin Model
 */
trait ClearsRejectionReasons
{
    protected static function bootClearsRejectionReasons()
    {
        static::saving(function (Model $model) {

            if ($model->isDirty('status') && $model->status !== 'rejected') {
                $model->rejection_reasons = null;
            }

            if ($model->isDirty('approved')) {

                $approvedValue = $model->approved instanceof UserStatus
                    ? $model->approved->value
                    : $model->approved;

                if ($approvedValue !== 'rejected') {
                    $model->rejection_reasons = null;
                }
            }

        });
    }
}
