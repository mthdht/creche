<?php

namespace App\Policies;

use App\Models\Daycare;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DaycarePolicy
{

    public function act(User $user, Daycare $daycare) 
    {
        return $daycare->user == $user;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {  
        return $user->profile->role == 'professional';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Daycare $daycare): bool
    {
        return $daycare->user == $user;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->profile->role == 'professional';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Daycare $daycare): bool
    {
        return $daycare->user == $user;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Daycare $daycare): bool
    {
        return $daycare->user == $user;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Daycare $daycare): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Daycare $daycare): bool
    {
        return false;
    }
}
