<?php

namespace App\Policies;

use App\Can;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

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
        //if ($user->role_id == 1) return true;
        //if ($user->role_id == 2) return true;
        if ($user->role_id == 3) {
            return !(DB::table('cans')->orWhere('status_sk', 3)->orWhere('status_sk', 0)->orWhere('status_sk', 1)->where('provinsi_id', $user->provinsi_id)->exists()) ? Response::allow()
                : Response::deny('Masih ada yang belum disetujui');
        }

        return false;
    }

    /** 
     * Determine whether the user can update from draft.
     * status_sk
     * 0 -> draft
     * 1 -> submit
     * 2 -> approved
     * 3 -> rejected
     * 4 -> approved (tidak aktif)
     * 
     * @param  \App\User  $user
     * @param  \App\Can  $can
     * @return mixed
     */
    public function update(User $user, Can $can)
    {
        if ($user->role_id == 3) {
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
        if ($user->role_id == 3) {
            return ($can->status_sk == 0 or $can->status_sk == 3)  ? $user->provinsi_id == $can->provinsi_id : false;
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
