<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->permissions['view_menu'];
    }

    public function create(User $user)
    {
        return $user->permissionsToEmployee['store_employee'];
    }

    public function update(User $user)
    {
        return $user->permissionsToEmployee['update_employee'];
    }

    public function destroy(User $user)
    {
        return $user->permissionsToEmployee['delete_employee'];
    }

}
