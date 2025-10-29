<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\UserProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_any_pending::profile');
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, UserProfile $userProfile): bool
    {
        return $admin->can('view_pending::profile');
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_pending::profile');
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, UserProfile $userProfile): bool
    {
        return $admin->can('update_pending::profile');
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, UserProfile $userProfile): bool
    {
        return $admin->can('delete_pending::profile');
    }

    /**
     * Determine whether the admin can bulk delete.
     */
    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_pending::profile');
    }

    /**
     * Determine whether the admin can permanently delete.
     */
    public function forceDelete(Admin $admin, UserProfile $userProfile): bool
    {
        return $admin->can('force_delete_pending::profile');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     */
    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('force_delete_any_pending::profile');
    }

    /**
     * Determine whether the admin can restore.
     */
    public function restore(Admin $admin, UserProfile $userProfile): bool
    {
        return $admin->can('restore_pending::profile');
    }

    /**
     * Determine whether the admin can bulk restore.
     */
    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('restore_any_pending::profile');
    }

    /**
     * Determine whether the admin can replicate.
     */
    public function replicate(Admin $admin, UserProfile $userProfile): bool
    {
        return $admin->can('replicate_pending::profile');
    }

    /**
     * Determine whether the admin can reorder.
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can('reorder_pending::profile');
    }
}
