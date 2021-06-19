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

        //Tabel Intervensi Khusus
        $ikDraft = IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun',  date("Y"))->where('status', 0)->count();
        $ikSubmit = IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun',  date("Y"))->where('status', 1)->count();
        $ikApproved = IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun',  date("Y"))->where('status', 2)->count();
        $ikRejected = IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun',  date("Y"))->where('status', 3)->count();


        //Tabel Report
        $reportSm1 = Report::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun',  date("Y"))->where('semester', 1)->first();
        $reportSm2 = Report::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun',  date("Y"))->where('semester', 2)->first();
        $reportSm1Status =  $reportSm1 != null ?  $reportSm1->status : 0;
        $reportSm2Status =  $reportSm2 != null ?  $reportSm2->status : 0;


        //Jumlah Can
        $latestCan = Can::where('provinsi_id', Auth::user()->provinsi_id)->latest("updated_at")->first();
        if ($latestCan != null) {
            $canId = $latestCan->id;
            $canCount = DB::table('can_user')->where('can_id', $canId)->count();
        } else {
            $canCount = 0;
        }

        //Jumlah Intervensi Nasional
        $inCount = IntervensiNasional::where('tahun', date("Y"))->count();

        //Jumlah Intervensi Khusus
        $intervensiKhususes = IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun', date("Y"))->where('status', 2)->get();
        $intervensiKhususKeys = $intervensiKhususes->modelKeys();
        $ikCount = IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun', date("Y"))->where('status', 2)->count();


        //Jumlah Progress
        $intervensiNasionals = IntervensiNasional::where('tahun', date("Y"))->get();
        $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
        $intervensiNasionalYearProvinsis = IntervensiNasionalProvinsi::whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();
        $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', Auth::user()->provinsi_id)->get();
        $intervensiNasionalProvinsiKeys =  $intervensiNasionalProvinsis->modelKeys();
        $pinCount =   $intervensiNasionalProvinsiKeys != 0 ?
            ProgressIntervensiNasional::whereIn('intervensi_nasional_provinsi_id', $intervensiNasionalProvinsiKeys)->count() : 0;
        $pikCount = $intervensiKhususKeys != 0 ? ProgressIntervensiKhusus::whereIn('intervensi_khusus_id', $intervensiKhususKeys)->count() : 0;
        $piCount = $pinCount + $pikCount;



        //progress Intervensi Nasional
        $pinMaxs = array();
        foreach ($intervensiNasionalProvinsiKeys as $inpk => $value) {
            $pinMax = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $value)->orderByDesc('bulan')->first();
            if ($pinMax != null) {
                $pinMaxs[] = $pinMax;
            }
        }

        //Progress Intervensi Khusus
        $pikMaxs = array();
        foreach ($intervensiKhususKeys as $ikk => $value) {
            $pikMax = ProgressIntervensiKhusus::where('intervensi_khusus_id', $value)->orderByDesc('bulan')->first();
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
        if (Auth::user()->role_id == 1) {
            return view('dashboardadmin');
        }

        return view('dashboard', compact('data', 'pinMaxs', 'pikMaxs'));
    }
}
