<?php

namespace App\Providers;

use App\Can;
use App\IntervensiKhusus;
use App\IntervensiNasional;
use App\IntervensiNasionalProvinsi;
use App\ProgressIntervensiKhusus;
use App\ProgressIntervensiNasional;
use App\Report;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer('layouts.sidebar', function ($view) {
            $user = Auth::user();
            $year = $user->getSetting('tahun');

            $counts = null;
            if ($user->isChangeLeader()) {
                // $counts = Cache::remember('counts', 3600, function () {
                //     return ['canCount' => 5, 'programCount' => 6, 'progressCount' => 7];
                // });


                $user = Auth::user();
                $year = $user->getSetting('tahun');
                $submittedCansCount = Can::where('provinsi_id', $user->provinsi_id)->where('tahun_sk', $year)->where('status_sk', 1)->count();

                $submittedIk = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('tahun', $year)->where('status', 1)->get();
                $submittedIkCount = 0;
                if ($submittedIk != null) {
                    $submittedIkCount = $submittedIk->count();
                }
                $intervensiNasionals = IntervensiNasional::where('tahun', $year)->get();
                $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
                $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->where('status', 1)->get();
                $submittedInCount = 0;
                if ($intervensiNasionalProvinsis != null) {
                    $submittedInCount = $intervensiNasionalProvinsis->count();
                }
                $submittedProgram = $submittedIkCount + $submittedInCount;


                $intervensiNasionalProvinsiApproved = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->where('status', 2)->get();
                $intervensiNasionalProvinsiApprovedModelKeys = $intervensiNasionalProvinsiApproved->modelKeys();
                $submittedPinCount =  $intervensiNasionalProvinsiApprovedModelKeys != 0 ?
                    ProgressIntervensiNasional::whereIn('intervensi_nasional_provinsi_id',  $intervensiNasionalProvinsiApprovedModelKeys)->where('status', 1)->count() : 0;
                $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('tahun', $year)->where('status', 2)->get();
                $intervensiKhususKeys = $intervensiKhususes->modelKeys();
                $submittedPikCount = $intervensiKhususKeys != 0 ? ProgressIntervensiKhusus::whereIn('intervensi_khusus_id', $intervensiKhususKeys)->where('status', 1)->count() : 0;

                $submittedProgress =  $submittedPinCount +  $submittedPikCount;

                $reportCount = Report::where('provinsi_id', $user->provinsi_id)->where('tahun', $year)->where('status', 1)->count();


                $counts = ['canCount' => $submittedCansCount, 'programCount' => $submittedProgram, 'progressCount' =>  $submittedProgress, 'reportCount' => $reportCount];
            } else {
                $counts = null;
            }
            return $view->with('counts', $counts);
        });
    }
}
