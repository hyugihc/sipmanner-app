<?php

namespace App\Policies;

use App\ProgramIntervensi;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramIntervensiPolicy
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
        return  $user->role_id == 4 ? false : true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgramIntervensi  $programIntervensi
     * @return mixed
     */
    public function view(User $user, ProgramIntervensi $programIntervensi)
    {
        //
        return $user->role_id == 1 or $user->role_id == 5 ? true : $user->provinsi_id == $programIntervensi->provinsi_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user->role_id == 4 or $user->role_id == 5 ? false : true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgramIntervensi  $programIntervensi
     * @return mixed
     */
    public function update(User $user, ProgramIntervensi $programIntervensi)
    {
        //
        if ($user->role_id == 4 or $user->role_id == 5) {
            return false;
        } elseif ($user->provinsi_id == $programIntervensi->provinsi_id or $user->role_id == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgramIntervensi  $programIntervensi
     * @return mixed
     */
    public function delete(User $user, ProgramIntervensi $programIntervensi)
    {
        //
        if ($user->role_id == 4 or $user->role_id == 5) {
            return false;
        } elseif ($user->provinsi_id == $programIntervensi->provinsi_id or $user->role_id == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgramIntervensi  $programIntervensi
     * @return mixed
     */
    public function restore(User $user, ProgramIntervensi $programIntervensi)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgramIntervensi  $programIntervensi
     * @return mixed
     */
    public function forceDelete(User $user, ProgramIntervensi $programIntervensi)
    {
        //
    }
}
