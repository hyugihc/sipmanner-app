<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IntervensiNasional;
use App\IntervensiKhusus;
use App\IntervensiNasionalProvinsi;
use App\Pia;
use App\Provinsi;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
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
        $currentYear = $user->getSetting('tahun');

        if ($user->isAdmin()) {
            $intervensiNasionals = IntervensiNasional::where('tahun', $currentYear)->get();
        } else {
            $intervensiNasionals = IntervensiNasional::where('tahun', $currentYear)->where("status", 2)->get();
            foreach ($intervensiNasionals as $intervensiNasional) {
                $intervensiNasionalProvinsi = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->where('intervensi_nasional_id', $intervensiNasional->id)->first();
                if ($intervensiNasionalProvinsi == null) {
                    $intervensiNasionalProvinsi =  new IntervensiNasionalProvinsi();
                    $intervensiNasionalProvinsi->provinsi_id = $user->provinsi_id;
                    $intervensiNasionalProvinsi->intervensi_nasional_id = $intervensiNasional->id;
                    $intervensiNasionalProvinsi->ukuran_keberhasilan = $intervensiNasional->ukuran_keberhasilan;
                    $intervensiNasionalProvinsi->status = 0;
                    $intervensiNasionalProvinsi->save();
                }
            }
            $intervensiNasionals = IntervensiNasional::where('tahun', $currentYear)->where("status", 2)->get();
            $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
            if ($user->isChangeChampion()) {
                $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();
            }
            if ($user->isChangeLeader()) {
                $clStatus = [1, 2];
                $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->whereIn('status', $clStatus)->get();
            }
        }


        if ($user->isAdmin()) {
            $intervensiKhususes = IntervensiKhusus::where('tahun', $currentYear)->get();
        } elseif ($user->isChangeLeader()) {
            $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('tahun', $currentYear)->where(function ($query) {
                $query->where('status', 1)->orWhere('status', 2);
            })->get();
        } elseif ($user->isChangeChampion()) {
            $intervensiKhususes = IntervensiKhusus::where('user_id', $user->id)->where('provinsi_id', $user->provinsi_id)->where('tahun', $currentYear)->get();
        }

        return view('programs.index', compact('intervensiKhususes', 'intervensiNasionals', 'intervensiNasionalProvinsis'));
    }
}
