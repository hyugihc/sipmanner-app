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
        $year = $user->getSetting('tahun');

        if ($user->isAdminorTopLeader()) {
            $intervensiNasionals = IntervensiNasional::where('tahun', $year)->where("status", 2)->get();
            $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
            $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('status', 2)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();
        }
        if ($user->isChangeChampion() or $user->isChangeLeader()) {
            $intervensiNasionals = IntervensiNasional::where('tahun', $year)->where("status", 2)->get();
            $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
            $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->where('status', 2)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();

        }

        $user = Auth::user();
        if ($user->isAdminorTopLeader()) {
            $intervensiKhususes = IntervensiKhusus::where('status', 2)->where('tahun', $year)->get();
        } elseif ($user->isChangeLeader()) {
            $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('status', 2)->where('tahun', $year)->get();
        } elseif ($user->isChangeChampion()) {
            $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('status', 2)->where('tahun', $year)->get();
        }
       

        return view('progress.index', compact('intervensiNasionalProvinsis', 'intervensiKhususes'));
    }

   
     
}
