<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IntervensiKhusus;
use App\IntervensiNasional;
use App\IntervensiNasionalProvinsi;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        // if ($user->isAdmin()) {
        //     $intervensiNasionals = IntervensiNasionalProvinsi::where('status', 2)->get();
        // }
        // if ($user->isChangeChampion() or $user->isChangeLeader()) {
        //     $intervensiNasionals = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->where('tahun', Date("Y"))->where('status, 2')->get();
        // }

        if ($user->isAdmin()) {
            $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('status', 2)->get();
        }
        if ($user->isChangeChampion() or $user->isChangeLeader()) {
            $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->where('status', 2)->get();
        }

        $user = Auth::user();
        if ($user->isAdmin()) {
            $intervensiKhususes = IntervensiKhusus::where('status', 2)->get();
        } elseif ($user->isChangeLeader()) {
            $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('status', 2)->get();
        } elseif ($user->isChangeChampion()) {
            $intervensiKhususes = IntervensiKhusus::where('user_id', $user->id)->where('provinsi_id', $user->provinsi_id)->where('status', 2)->get();
        }

        return view('progress.index', compact('intervensiNasionalProvinsis', 'intervensiKhususes'));
    }
}
