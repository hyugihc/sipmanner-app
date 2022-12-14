<?php

namespace App\Policies;

use App\IntervensiKhusus;
use App\ProgressIntervensiKhusus;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProgressIntervensiKhususPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user, IntervensiKhusus $intervensiKhusus)
    {
        //
        if ($user->role_id == 1) return true; //adminTS
        if ($user->role_id == 5) return true; //tl
        if ($intervensiKhusus->provinsi_id = $user->provinsi_id) {

            if ($user->role_id == 2) return true; //cl
            if ($user->role_id == 3) return true; //cc
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return mixed
     */
    public function view(User $user, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        if ($user->role_id == 1) return true;
        if ($user->role_id == 5) return true;
        if ($user->role_id == 3 or $user->role_id == 2) {
            return  $user->provinsi_id == $progressIntervensiKhusus->intervensi_khusus['provinsi_id'];
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, IntervensiKhusus $intervensiKhusus)
    {
        //deny jika user bukan change champion
        if ($user->role_id != 3) return Response::deny('Anda bukan change champion');
        //deny jika user_id intervensi_khusus tidak sama dengan user id
        if ($user->id != $intervensiKhusus->user_id) return Response::deny('Anda bukan pembuat rencana aksi ini');
        //deny jika provinsi_id intervensi_khusus tidak sama dengan user provinsi_id
        if ($user->provinsi_id != $intervensiKhusus->provinsi_id) return Response::deny('satker tidak sama');
        return true;
        
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return mixed
     */
    public function update(User $user, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //

        if ($user->role_id == 3 and $user->id == $progressIntervensiKhusus->intervensi_khusus->user_id) {
            if ($progressIntervensiKhusus->status == 3 or $progressIntervensiKhusus->status == 0)
                return  $user->provinsi_id == $progressIntervensiKhusus->intervensi_khusus['provinsi_id'];
            return false;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return mixed
     */
    public function delete(User $user, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //

        if ($user->role_id == 3 and $user->id == $progressIntervensiKhusus->intervensi_khusus->user_id) {
            if ($progressIntervensiKhusus->status == 3 or $progressIntervensiKhusus->status == 0)
                return  $user->provinsi_id == $progressIntervensiKhusus->intervensi_khusus['provinsi_id'];
            return false;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return mixed
     */
    public function restore(User $user, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return mixed
     */
    public function forceDelete(User $user, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
    }

    public function approve(User $user, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        if ($user->role_id == 2 and $progressIntervensiKhusus->status != 2) {
            return $user->provinsi_id == $progressIntervensiKhusus->intervensi_khusus->provinsi_id;
        }
        return false;
    }
}
