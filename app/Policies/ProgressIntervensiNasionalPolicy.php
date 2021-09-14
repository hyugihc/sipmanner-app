<?php

namespace App\Policies;

use App\ProgressIntervensiNasional;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgressIntervensiNasionalPolicy
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
        if ($user->role_id == 1) return true; //adminTS
        if ($user->role_id == 2) return true; //cl
        if ($user->role_id == 3) return true; //cc
        if ($user->role_id == 5) return true; //tl
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return mixed
     */
    public function view(User $user, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
        if ($user->role_id == 1) return true;
        if ($user->role_id == 5) return true;
        if ($user->role_id == 3 or $user->role_id == 2) {
            return  $user->provinsi_id == $progressIntervensiNasional->intervensiNasionalProvinsi->provinsi_id;
        }
        return false;
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
        if ($user->role_id == 3) return true; //cc
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return mixed
     */
    public function update(User $user, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
        if ($user->role_id == 3 and ($progressIntervensiNasional->status == 3 or $progressIntervensiNasional->status == 0)) {
            return  $user->provinsi_id == $progressIntervensiNasional->intervensiNasionalProvinsi->provinsi_id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return mixed
     */
    public function delete(User $user, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
        if ($user->role_id == 3 and $progressIntervensiNasional->status == 3) {
            return  $user->provinsi_id == $progressIntervensiNasional->intervensiNasionalProvinsi->provinsi_id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return mixed
     */
    public function restore(User $user, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return mixed
     */
    public function forceDelete(User $user, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
    }

    public function approve(User $user, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        if ($user->role_id == 2 and $progressIntervensiNasional->status == 1) {
            return $user->provinsi_id == $progressIntervensiNasional->intervensiNasionalProvinsi->provinsi_id;
        }
        return false;
    }
}
