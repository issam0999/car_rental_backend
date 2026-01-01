<?php

namespace App\Policies;

use App\Models\Center;
use App\Models\User;

class CenterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false; // only super-admin
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Center $center): bool
    {
        return $center->id === $user->center_id && $user->can('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Center $center): bool
    {
        return $center->id === $user->center_id && $user->can('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Center $center): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Center $center): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Center $center): bool
    {
        return false;
    }
}
