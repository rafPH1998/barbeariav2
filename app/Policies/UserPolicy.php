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

    public function create(User $user): bool
    {
        return $user->permissionsToEmployee['store_employee'];
    }

    public function update(User $user): bool
    {
        return $user->permissionsToEmployee['update_employee'];
    }

    public function destroy(User $user): bool
    {
        return $user->permissionsToEmployee['delete_employee'];
    }

}
