<?php

namespace App\Policies;

use App\IntervensiNasionalProvinsi;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IntervensiNasionalProvinsiPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiNasionalProvinsi  $intervensiNasionalProvinsi
     * @return mixed
     */
    public function view(User $user, IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //
        if ($user->isChangeChampion() or $user->isChangeLeader())
            return $user->provinsi_id == $intervensiNasionalProvinsi->provinsi_id;
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
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiNasionalProvinsi  $intervensiNasionalProvinsi
     * @return mixed
     */
    public function update(User $user, IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //
        if ($user->isChangeChampion() and ($intervensiNasionalProvinsi->status == 0 or $intervensiNasionalProvinsi->status == 3))
            return $user->provinsi_id == $intervensiNasionalProvinsi->provinsi_id;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiNasionalProvinsi  $intervensiNasionalProvinsi
     * @return mixed
     */
    public function delete(User $user, IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiNasionalProvinsi  $intervensiNasionalProvinsi
     * @return mixed
     */
    public function restore(User $user, IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiNasionalProvinsi  $intervensiNasionalProvinsi
     * @return mixed
     */
    public function forceDelete(User $user, IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //
    }

    public function approve(User $user, IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        if ($user->isChangeLeader() and $intervensiNasionalProvinsi->status == 1) {
            return $user->provinsi_id == $intervensiNasionalProvinsi->provinsi_id;
        }
        return false;
    }
}
