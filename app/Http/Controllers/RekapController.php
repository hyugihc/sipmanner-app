<?php

namespace App\Http\Controllers;

use App\IntervensiKhusus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapController extends Controller
{
    //munculkan fungsi index
    public function index()
    {
        $user = Auth::user();
        $currentYear = $user->getSetting('tahun');

        //ambil intervensi khusus pada tahun current year
        $intervensiKhususes = IntervensiKhusus::where('tahun', $currentYear)->get();
        //buat rekap per provinsi
        $rekapPerProvinsi = $intervensiKhususes->groupBy('provinsi_id');

        //tampilkan ke sebuah tabel
        return view('rekap.index', compact('intervensiKhususes', 'rekapPerProvinsi'));
    }
}
