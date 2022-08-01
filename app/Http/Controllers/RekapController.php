<?php

namespace App\Http\Controllers;

use App\IntervensiKhusus;
use App\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapController extends Controller
{
    //munculkan fungsi index
    public function indexIntervensiKhusus()
    {
        $user = Auth::user();
        $currentYear = $user->getSetting('tahun');

        //ambil semua provinsi dari database
        $provinsis = Provinsi::all();
        //tampilkan ke sebuah tabel
        return view('programs.rekap.index', compact('provinsis', 'currentYear'));
    }
}
