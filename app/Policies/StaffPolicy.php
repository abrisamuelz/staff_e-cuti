<?php

namespace App\Policies;

use App\Models\Staff;
use App\Models\User;

class StaffPolicy
{
    /**
     * Determine whether the user can view any staff.
     */
    public function viewAny(User $user): bool
    {
        // Allow only users with the 'admin' role
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the staff.
     */
    public function view(User $user, Staff $staff): bool
    {
        // Allow only users with the 'admin' role
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create staff.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the staff.
     */
    public function update(User $user, Staff $staff): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the staff.
     */
    public function delete(User $user, Staff $staff): bool
    {
        return $user->role === 'admin';
    }
}
