<?php

namespace App\Policies;

use App\Can;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Can  $can
     * @return mixed
     */
    public function view(User $user, Can $can)
    {
        return $user->role_id == 1 or $user->role_id == 5  ? true : $user->provinsi_id == $can->provinsi_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role_id == 4 or $user->role_id == 5 ? false : true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Can  $can
     * @return mixed
     */
    public function update(User $user, Can $can)
    {
        //
        if ($user->role_id == 1) {
            return true;
        } elseif ($user->role_id == 4 or $user->role_id == 5) {
            return false;
        } elseif ($user->provinsi_id == $can->provinsi_id and $can->approval != 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Can  $can
     * @return mixed
     */
    public function delete(User $user, Can $can)
    {
        //
        if ($user->role_id == 1) {
            return true;
        } elseif ($user->role_id == 4 or $user->role_id == 5) {
            return false;
        } elseif ($user->provinsi_id == $can->provinsi_id and $can->approval != 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Can  $can
     * @return mixed
     */
    public function restore(User $user, Can $can)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Can  $can
     * @return mixed
     */
    public function forceDelete(User $user, Can $can)
    {
        //
    }
}
