<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IntervensiNasional;
use App\IntervensiKhusus;
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
        $currentYear = date("Y");

        $intervensiNasionals = IntervensiNasional::where('tahun', $currentYear)->where("status", 2)->get();
        
        if ($user->isAdmin()) {
            $intervensiKhususes = IntervensiKhusus::where('tahun', $currentYear)->get();
        } elseif ($user->isChangeLeader()) {
            $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('tahun', $currentYear)->where(function ($query) {
                $query->where('status', 1)->orWhere('status', 2);
            })->get();
        } elseif ($user->isChangeChampion()) {
            $intervensiKhususes = IntervensiKhusus::where('user_id', $user->id)->where('provinsi_id', $user->provinsi_id)->where('tahun', $currentYear)->get();
        }

        return view('programs.index', compact('intervensiKhususes', 'intervensiNasionals'));
    }
}
