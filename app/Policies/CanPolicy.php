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
        if (($user->isChangeChampion() or $user->isChangeLeader()) and $user->provinsi->isPusat()) {
            return $can->isCanPusat();
        }
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
        $year = $user->getSetting('tahun');

        if ($user->isAdmin()) {
            $can = Can::where('pusat', 1)->where('tahun_sk', $year)->where('status_sk', '!=', '2')->count();
            if ($can != 0) {
                return Response::deny('Masih ada yang belum disetujui');
            } else {
                return Response::allow();
            }
            return true;
        }
        if ($user->isChangeChampion()) {
            if ($user->provinsi->isNotPusat()) {
                return Response::allow();
            } else {
                return Response::deny('Hanya Admin yang bisa upload Data CAN BPS Pusat');
            }
        }
        return Response::deny('Hanya Admin dan changechampion yang bisa membuat data CAN');
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
        if ($user->isAdmin() and $can->isCanPusat()) {
            if ($can->status_sk == 0 or $can->status_sk == 3) {
                return true;
            }
        }

        if ($user->isChangeChampion() and  $user->provinsi->isNotPusat()) {
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
        if ($user->isAdmin() and $can->isCanPusat()) {
            if ($can->status_sk == 0 or $can->status_sk == 3) {
                return true;
            }
        }
        if ($user->isChangeChampion() and  $user->provinsi->isNotPusat()) {
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
        if ($user->isAdmin() and $can->isCanPusat()) {
            return true;
        }

        if ($user->isChangeLeader() and $can->status_sk == 1) {
            return $user->provinsi_id == $can->provinsi_id;
        }
        return false;
    }
}
