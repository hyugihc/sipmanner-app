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

        if ($user->isAdmin()) return true; //adminTS
        if ($user->isChangeLeader()) return true; //cl
        if ($user->isChangeChampion()) return true; //cc
        if ($user->isTopLeader()) return true; //tl
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
        if ($user->isAdmin()) return true;
        if ($user->isTopLeader()) return true;
        if ($user->isChangeChampion() or $user->isChangeLeader()) {
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
        if ($user->isChangeChampion()) {
            // $can = Can::where('provinsi_id', $user->provinsi_id)->where('tahun_sk', Date("y"))->where(function ($q) {
            //     return $q->where('status_sk', 0)->orWhere('status_sk', 3)->orWhere('status_sk', 4)->exist();
            // });
            $can = Can::where('provinsi_id', $user->provinsi_id)->where('tahun_sk', Date("y"))->where('status_sk', '!=', '2')->count();
            if ($can != 0) {
                return Response::deny('Masih ada yang belum disetujui');
            } else {
                return Response::allow();
            }
            // return !(DB::table('cans')->where('provinsi_id', $user->provinsi_id)->orWhere('status_sk', 3)->orWhere('status_sk', 0)->orWhere('status_sk', 1)->exists()) ? Response::allow()
            //     : Response::deny('Masih ada yang belum disetujui');
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
        if ($user->isChangeChampion()) {
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
        if ($user->isChangeChampion()) {
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
        if ($user->isChangeLeader() and $can->status_sk == 1) {
            return $user->provinsi_id == $can->provinsi_id;
        }
        return false;
    }
}
