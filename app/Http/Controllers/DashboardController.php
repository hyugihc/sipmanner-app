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
use App\Provinsi;
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

        //jika admin
        if ($user->isAdminOrTopLeader()) {

            //============================pie chart====================================
            //tampilkan data intervensi khusus yang draft, submitted, approved & rejected
            $intervensi_khusus = IntervensiKhusus::where('tahun', $year)->get();
            $ikDraft = $intervensi_khusus->where('status', '0')->count();
            $ikSubmit = $intervensi_khusus->where('status', '1')->count();
            $ikApproved = $intervensi_khusus->where('status', '2')->count();
            $ikRejected = $intervensi_khusus->where('status', '3')->count();

            //=====================================smallbox===========================
            //tambahkan jumlah can pada setiap can seluruh indonesia yang sudah diapprove
            $can = Can::where('tahun_sk', $year)->get();
            $can_approved = $can->where('status', '2');
            $canCount = 0;
            foreach ($can_approved as $can) {
                $canCount += $can->jumlah_can;
            }

            //hitung data intervensi nasional yang sudah diapprove
            $intervensi_nasional = IntervensiNasional::where('tahun', $year)->get();
            $inCount = $intervensi_nasional->where('status', '2')->count();

            //hitung data intervensi khusus yang sudah diapprove pada tahun setting
            $ikCount =  IntervensiKhusus::where('tahun', $year)->where('status', 2)->count();

            $data = [
                //pie chart
                'ikDraft'  => $ikDraft,

                'ikSubmit'   => $ikSubmit,

                'ikApproved' => $ikApproved,

                'ikRejected' => $ikRejected,
                // smalbox
                'inCount' => $inCount,

                'ikCount' => $ikCount,

                'canCount' => $canCount,
            ];

            //=================tabel rekap rencana aksi==============

            //ambil semua provinsi dari database
            $provinsis = Provinsi::all();

            //kembalikan ke view dashboard untuk admin dan top leader
            return view('dashboard.admin-tl', compact('data', 'provinsis'));
        }



        //==================================Pie Chart===================================================

        // Progres Intervensi Khusus by CC

        $intervensiKhususesByUser = ($user->isAdmin()) ?  IntervensiKhusus::where('tahun',  $year)->get()
            : IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('tahun',  $year)->get();
        $ikDraft = $intervensiKhususesByUser->where('status', 0)->count();
        $ikSubmit = $intervensiKhususesByUser->where('status', 1)->count();
        $ikApproved = $intervensiKhususesByUser->where('status', 2)->count();
        $ikRejected = $intervensiKhususesByUser->where('status', 3)->count();

        //===================================Small Box==================================================

        //Jumlah Can

        if ($user->isAdmin()) {
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
        $ikCount = 0;
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
            $statusProgres=[1,2];
            $pinMax = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $value)->whereIn('status', $statusProgres)->orderByDesc('realisasi_pelaksanaan_kegiatan')->first();
            if ($pinMax != null) {
                $pinMaxs[] = $pinMax;
            }
        }

        //Progress Intervensi Khusus
        $pikMaxs = array();
        foreach ($intervensiKhususKeys as $ikk => $value) {
            $statusProgres=[1,2];
            $pikMax = ProgressIntervensiKhusus::where('intervensi_khusus_id', $value)->whereIn('status', $statusProgres)->orderByDesc('tanggal')->first();
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
