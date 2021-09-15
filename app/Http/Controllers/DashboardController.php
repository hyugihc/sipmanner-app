<?php

namespace App\Http\Controllers;

use App\Can;
use App\Dashboard;
use Illuminate\Http\Request;

use App\IntervensiNasional;
use App\IntervensiKhusus;
use App\ProgressIntervensiKhusus;
use App\ProgressIntervensiNasional;
use App\IntervensiNasionalProvinsi;
use App\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        $year = $user->getSetting('tahun');


        //==================================Pie Chart===================================================

        // Progres Intervensi Khusus by CC

        $intervensiKhususesByUser = ($user->role_id == 1) ?  IntervensiKhusus::where('tahun',  $year)->get()
            : IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('tahun',  $year)->get();
        $ikDraft = $intervensiKhususesByUser->where('status', 0)->count();
        $ikSubmit = $intervensiKhususesByUser->where('status', 1)->count();
        $ikApproved = $intervensiKhususesByUser->where('status', 2)->count();
        $ikRejected = $intervensiKhususesByUser->where('status', 3)->count();

        //===================================Small Box==================================================

        //Jumlah Can
        //$latestCan = Can::where('provinsi_id', $user->provinsi_id)->latest("updated_at")->first();
        if ($user->role_id == 1) {
            $cans = Can::where('status_sk', 2)->where('tahun_sk', $year)->get();
            if ($cans != null) {
                $canCount = 0;
                foreach ($cans as $can) {
                    $count = DB::table('can_user')->where('can_id', $can->id)->count();
                    $canCount = $canCount + $count;
                }
            } else {
                $canCount = 0;
            }
        } else {
            $latestCan = Can::where('provinsi_id', $user->provinsi_id)->where('status_sk', 2)->where('tahun_sk', $year)->first();
            if ($latestCan != null) {
                $canId = $latestCan->id;
                $canCount = DB::table('can_user')->where('can_id', $canId)->count();
            } else {
                $canCount = 0;
            }
        }


        //Jumlah Intervensi Nasional
        $inCount = IntervensiNasional::where('tahun', $year)->where('status', 2)->count();

        //Jumlah Intervensi Khusus
        if ($user->isAdmin() or $user->isTopLeader()) {
            $ikCount =  IntervensiKhusus::where('tahun', $year)->where('status', 2)->count();
        } elseif ($user->isChangeLeader() or $user->isChangeChampion()) {
            $ikCount = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('tahun', $year)->where('status', 2)->count();
        }

        //Jumlah Progress
        //progress Intervensi Nasional
        $intervensiNasionals = IntervensiNasional::where('tahun', $year)->get();
        $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
        // $intervensiNasionalYearProvinsis = IntervensiNasionalProvinsi::whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();
        $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();
        $intervensiNasionalProvinsiKeys =  $intervensiNasionalProvinsis->modelKeys();
        $pinCount =   $intervensiNasionalProvinsiKeys != 0 ?
            ProgressIntervensiNasional::whereIn('intervensi_nasional_provinsi_id', $intervensiNasionalProvinsiKeys)->where('status', 2)->count() : 0;

        //progress Intervensi Khusus
        $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('tahun', $year)->where('status', 2)->get();
        $intervensiKhususKeys = $intervensiKhususes->modelKeys();
        $pikCount = $intervensiKhususKeys != 0 ? ProgressIntervensiKhusus::whereIn('intervensi_khusus_id', $intervensiKhususKeys)->where('status', 2)->count() : 0;

        //progress Intervensi Nasional +progress Intervensi Khusus
        $piCount = $pinCount + $pikCount;

        //====================================Tabel Progress=================================================

        //Tabel progress Report
        $reportSm1 = Report::where('provinsi_id', $user->provinsi_id)->where('tahun',  $year)->where('semester', 1)->first();
        $reportSm2 = Report::where('provinsi_id', $user->provinsi_id)->where('tahun',  $year)->where('semester', 2)->first();
        $reportSm1Status =  $reportSm1 != null ?  $reportSm1->status : 0;
        $reportSm2Status =  $reportSm2 != null ?  $reportSm2->status : 0;

        //progress Intervensi Nasional
        $pinMaxs = array();
        foreach ($intervensiNasionalProvinsiKeys as $inpk => $value) {
            $pinMax = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $value)->where('status', 2)->orderByDesc('bulan')->first();
            if ($pinMax != null) {
                $pinMaxs[] = $pinMax;
            }
        }

        //Progress Intervensi Khusus
        $pikMaxs = array();
        foreach ($intervensiKhususKeys as $ikk => $value) {
            $pikMax = ProgressIntervensiKhusus::where('intervensi_khusus_id', $value)->where('status', 2)->orderByDesc('tanggal')->first();
            if ($pikMax != null) {
                $pikMaxs[] = $pikMax;
            }
        }


        $data = [

            'ikDraft'  => $ikDraft,

            'ikSubmit'   => $ikSubmit,

            'ikApproved' => $ikApproved,

            'ikRejected' => $ikRejected,

            'reportSm1Status' => $reportSm1Status,

            'reportSm2Status' => $reportSm2Status,

            'inCount' => $inCount,

            'ikCount' => $ikCount,

            'canCount' => $canCount,

            'piCount' => $piCount

        ];
        // if ($user->role_id == 1) {
        //     return view('dashboardadmin');
        // }

        return view('dashboard', compact('data', 'pinMaxs', 'pikMaxs'));
    }
}
