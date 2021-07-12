<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IntervensiKhusus;
use App\IntervensiNasional;
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
        $intervensiNasionals = IntervensiNasional::get();

        $user = Auth::user();
        if ($user->role_id == 1) {
            $intervensiKhususes = IntervensiKhusus::where('status', 2)->get();
        } elseif ($user->role_id  == 2) {
            $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('status', 2)->get();
        } elseif ($user->role_id  == 3) {
            $intervensiKhususes = IntervensiKhusus::where('user_id', $user->id)->where('provinsi_id', $user->provinsi_id)->where('status', 2)->get();
        }

        return view('progress.index', compact('intervensiNasionals', 'intervensiKhususes'));
    }
}
