<?php

namespace App\Policies;

use App\Report;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use Illuminate\Auth\Access\Response;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user repo$report view any models.
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
        //if ($user->role_id == 5) return true; //tl
        return false;
    }

    /**
     * Determine whether the user repo$report view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function view(User $user, Report $report)
    {
        //

        if ($user->role_id == 1) return true; //adminTS
        //jika masih draft, hanya CC dan CL satkernya yang bisa melihat
        if ($report->status == 0 or $report->status == 3) {
            if ($user->role_id == 3) {
                return $user->provinsi_id == $report->provinsi_id;
            } else {
                return Response::deny('Laporan masih bersatus draft');
            }
        }
        //Jika sudah diajukan dan diapprove, CC dan CL bisa melihat satker lain
        if ($report->status == 1 or $report->status == 2 or $report->status == 4) {
            if ($user->role_id == 2) return true; //cl
            if ($user->role_id == 3) return true; //cc
            return false;
        }
        return false;
    }


    /**
     * Determine whether the user repo$report create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user repo$report update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function update(User $user, Report $report)
    {
        //
        if ($user->role_id == 1) return true; //adminTS
        if ($user->role_id == 3 and ($report->status == 0 or $report->status == 3)) return $user->provinsi_id == $report->provinsi_id; //cc
        return false;
    }

    /**
     * Determine whether the user repo$report delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function delete(User $user, Report $report)
    {
        //
        if ($user->role_id == 1) return true; //adminTS
        if ($user->isChangeChampionOf($report->provinsi_id)) {
            if ($report->status == 0 or $report->status == 3) return true;
            return false;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user repo$report restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function restore(User $user, Report $report)
    {
        //
        if ($user->role_id == 1) return true; //adminTS
    }

    /**
     * Determine whether the user repo$report permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function forceDelete(User $user, Report $report)
    {
        //
    }

    public function approve(User $user, Report $report)
    {
        if ($user->role_id == 1) return true; //adminTS
        if ($user->role_id == 2) {
            if ($report->status == 1 or $report->status == 3) {
                return $user->provinsi_id == $report->provinsi_id;
            } else {
                //Tambahkan pesan error, jika status bukan 1 atau 3
                return Response::deny('Laporan tidak berstatus diajukan ke Change Leader');
            }
        }
        return false;
    }

    //upload laporan
    public function uploadLaporan(User $user, Report $report)
    {
        if ($user->role_id == 1) return true; //adminTS
        if ($user->role_id == 3) {
            if ($report->status == 2) {
                return $user->provinsi_id == $report->provinsi_id;
            } else {
                return false;
            }
        }
        return false;
    }

    //unsubmit
    public function unsubmit(User $user, Report $report)
    {

        if ($user->role_id == 3 or $user->role_id == 1) {
            if ($report->status == 1) {
                return $user->provinsi_id == $report->provinsi_id;
            } else {
                return false;
            }
        }
        return false;
    }
}
