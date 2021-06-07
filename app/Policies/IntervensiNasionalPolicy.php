<?php

namespace App\Policies;

use App\IntervensiNasional;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IntervensiNasionalPolicy
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
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return mixed
     */
    public function view(User $user, IntervensiNasional $intervensiNasional)
    {
        //
        if ($user->role_id == 1) return true; //adminTS
        if ($user->role_id == 2) return true; //cl
        if ($user->role_id == 3) return true; //cc
        if ($user->role_id == 5) return true; //tl
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
        if ($user->role_id == 1) return true; //adminTS
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return mixed
     */
    public function update(User $user, IntervensiNasional $intervensiNasional)
    {
        //
        if ($user->role_id == 1) return true; //adminTS
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return mixed
     */
    public function delete(User $user, IntervensiNasional $intervensiNasional)
    {
        //
        if ($user->role_id == 1) return true; //adminTS
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return mixed
     */
    public function restore(User $user, IntervensiNasional $intervensiNasional)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return mixed
     */
    public function forceDelete(User $user, IntervensiNasional $intervensiNasional)
    {
        //
    }
}
