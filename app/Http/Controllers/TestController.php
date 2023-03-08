<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Can;
use App\Http\Requests\StoreCanRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
//define Notification and CanSumbittedToCL
use Illuminate\Support\Facades\Notification;
use App\Notifications\CanSubmittedToCL;
//define log
use Illuminate\Support\Facades\Log;
//define Intervensi khusus
use App\IntervensiKhusus;
use App\Notifications\IntervensiKhususSubmittedToCL;
//define Intervensi nasional provinsi
use App\IntervensiNasionalProvinsi;
use App\Notifications\IntervensiNasionalProvinsiSubmitted;
use App\Notifications\ProgressInKusSubmittedToCL;
use App\Notifications\ProgressInNasSubmittedToCL;
use App\ProgressIntervensiKhusus;
use App\ProgressIntervensiNasional;
use App\Report;
use App\Notifications\ReportSubmittedToCL;


class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //find user yang punya email refnita.mulya@bps.go.id
        $changeLeader = User::where('email', 'refnita.mulya@bps.go.id')->first();
        // find user yang punya email yoga.wira@bps.go.id
        $changeLeader2 = User::where('email', 'yoga.wira@bps.go.id')->first();
        //ambil can terakhir yang berstatus 1
        $can = Can::where('status_sk', 1)->orderBy('id', 'desc')->first();
        //ambil intervensi khusus terakhir yang berstatus 1
        $intervensiKhusus = IntervensiKhusus::where('status', 1)->orderBy('id', 'desc')->first();
        //ambil intervensi nasional provinsi terakhir yang berstatus 1
        $intervensiNasionalProvinsi = IntervensiNasionalProvinsi::where('status', 1)->orderBy('id', 'desc')->first();
        //ambil progress intervensi khusus terakhir yang berstatus 1
        $progressIntervensiKhusus = ProgressIntervensiKhusus::where('status', 1)->orderBy('id', 'desc')->first();
        //ambil intervensi khusus dari progres tersebut
        $intervensiKhusus = IntervensiKhusus::where('id', $progressIntervensiKhusus->intervensi_khusus_id)->first();
        //ambil progress intervensi nasional provinsi terakhir yang berstatus 1
        $progressIntervensiNasionalProvinsi = ProgressIntervensiNasional::where('status', 1)->orderBy('id', 'desc')->first();
        //ambil intervensi nasional provinsi dari progres tersebut
        $intervensiNasionalProvinsi = IntervensiNasionalProvinsi::where('id', $progressIntervensiNasionalProvinsi->intervensi_nasional_provinsi_id)->first();
        //ambil report terakhir
        $report = Report::where('status', 1)->orderBy('id', 'desc')->first();
        try {
            //kirim notifikasi ke change leader

            Notification::send($changeLeader, new CanSubmittedToCL($can));
            Notification::send($changeLeader, new IntervensiKhususSubmittedToCL($intervensiKhusus));
            Notification::send($changeLeader, new IntervensiNasionalProvinsiSubmitted($intervensiNasionalProvinsi, $changeLeader2));
            Notification::send($changeLeader, new ProgressInKusSubmittedToCL($intervensiKhusus, $progressIntervensiKhusus));
            Notification::send($changeLeader, new ProgressInNasSubmittedToCL($intervensiNasionalProvinsi, $progressIntervensiNasionalProvinsi, $changeLeader2));
            Notification::send($changeLeader, new ReportSubmittedToCL($report));

            dd('berhasil');
        } catch (\Exception $e) {
            //jika gagal, log errornya
            dd($e->getMessage());
        }
    }
}
