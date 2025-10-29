<?php

namespace App\Models;

use App\Enum\AdminRole;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property AdminRole $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 *
 * @method static Builder<static>|Admin newModelQuery()
 * @method static Builder<static>|Admin newQuery()
 * @method static Builder<static>|Admin query()
 * @method static Builder<static>|Admin whereCreatedAt($value)
 * @method static Builder<static>|Admin whereEmail($value)
 * @method static Builder<static>|Admin whereId($value)
 * @method static Builder<static>|Admin whereName($value)
 * @method static Builder<static>|Admin wherePassword($value)
 * @method static Builder<static>|Admin whereRole($value)
 * @method static Builder<static>|Admin whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles,Notifiable;

    protected $guard_name = 'admin';

    protected $fillable = ['name', 'email', 'password', 'username'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',

    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
