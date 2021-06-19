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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
