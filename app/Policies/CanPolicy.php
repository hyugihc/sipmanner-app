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

        if ($user->role_id == 1) return true;
        if ($user->role_id == 2) return true;
        if ($user->role_id == 3) return true;
        if ($user->role_id == 5) return true;
        return false;
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
        if ($user->role_id == 1) return true;
        if ($user->role_id == 5) return true;
        if ($user->role_id == 3 or $user->role_id == 2) {
            return  $user->provinsi_id == $can->provinsi_id;
        }
        return false;
    }

    /**
     * Determine whether the user can create.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->role_id == 1) return true;
        if ($user->role_id == 2) return true;
        if ($user->role_id == 3) return true;

        return false;
    }

    /** 
     * Determine whether the user can update from draft.
     *
     * @param  \App\User  $user
     * @param  \App\Can  $can
     * @return mixed
     */
    public function update(User $user, Can $can)
    {
        if ($user->role_id == 3 or $user->role_id == 2) {
            if ($can->status_sk == 0 or $can->status_sk == 3) {
                return $user->provinsi_id == $can->provinsi_id;
            }
        }
        return false;
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
        if ($user->role_id == 1) return true;
        if ($user->role_id == 2 or $user->role_id == 3) {
            return $can->status_sk == 0 ? $user->provinsi_id == $can->provinsi_id : false;
        }
        return false;
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

    public function approve(User $user, Can $can)
    {
        if ($user->role_id == 2 and $can->status_sk == 1) {
            return $user->provinsi_id == $can->provinsi_id;
        }
        return false;
    }
}
