<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\IntervensiNasional;
use App\IntervensiKhusus;
use App\ProgressIntervensiKhusus;
use App\ProgressIntervensiNasional;

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
        //

        
        return view('dashboard');    
    }
}
