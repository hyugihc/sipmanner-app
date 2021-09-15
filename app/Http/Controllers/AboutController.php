<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    //
    public function index()
    {
        //
        $user = Auth::user();
        return view('about', compact('user'));
    }

    public function gantiTahun(Request $request)
    {
        $user = Auth::user();
        $user->setSetting('tahun', $request->tahun);
        $message= "Perubahan berhasil disimpan";
        return redirect()->route('dashboard') ->with('success', $message);;
    }
}
