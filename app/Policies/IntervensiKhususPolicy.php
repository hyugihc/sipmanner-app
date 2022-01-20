<?php

namespace App\Policies;

use App\IntervensiKhusus;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IntervensiKhususPolicy
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
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return mixed
     */
    public function view(User $user, IntervensiKhusus $intervensiKhusus)
    {
        //

        if ($user->role_id == 1) return true;
        if ($user->role_id == 5) return true;
        if ($user->role_id == 3 or $user->role_id == 2) {
            return  $user->provinsi_id == $intervensiKhusus->provinsi_id;
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
        //if ($user->role_id == 2) return true; //cl
        if ($user->role_id == 3) return true; //cc
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return mixed
     */
    public function update(User $user, IntervensiKhusus $intervensiKhusus)
    {
        //
        if ($intervensiKhusus->status == 2 or $intervensiKhusus->status == 1) return false;
        if ($user->role_id == 3 and  $user->provinsi_id == $intervensiKhusus->provinsi_id) {
            return $intervensiKhusus->user_id == $user->id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return mixed
     */
    public function delete(User $user, IntervensiKhusus $intervensiKhusus)
    {
        //
        if ($intervensiKhusus->status == 2 or $intervensiKhusus->status == 1) return false;
        if ($user->role_id == 3 and  $user->provinsi_id == $intervensiKhusus->provinsi_id) {
            return $intervensiKhusus->user_id == $user->id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return mixed
     */
    public function restore(User $user, IntervensiKhusus $intervensiKhusus)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return mixed
     */
    public function forceDelete(User $user, IntervensiKhusus $intervensiKhusus)
    {
        //
    }

    public function approve(User $user, IntervensiKhusus $intervensiKhusus)
    {
        if ($user->role_id == 2 and $intervensiKhusus->status == 1) {
            return $user->provinsi_id == $intervensiKhusus->provinsi_id;
        }
        return false;
    }
}
