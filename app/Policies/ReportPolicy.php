<?php

namespace App\Policies;

use App\Report;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
        if ($user->role_id == 5) return true; //tl
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
        if ($user->role_id == 2) return $user->provinsi_id == $report->provinsi_id; //cl
        if ($user->role_id == 3) return $user->provinsi_id == $report->provinsi_id; //cc
        if ($user->role_id == 5) return true; //tl
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
        if ($user->role_id == 3 and $report->status == 0) return $user->provinsi_id == $report->provinsi_id; //cc
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
        return false;
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
        if ($user->role_id == 2) {
            if ($report->status == 1 or $report->status == 3) {
                return $user->provinsi_id == $report->provinsi_id;
            } else {
                return false;
            }
        }
        return false;
    }

        
}
