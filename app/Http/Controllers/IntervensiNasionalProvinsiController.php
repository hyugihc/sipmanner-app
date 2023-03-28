<?php

namespace App\Http\Controllers;

use App\IntervensiNasionalProvinsi;
use App\Provinsi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
//define log
use Illuminate\Support\Facades\Log;

class IntervensiNasionalProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\IntervensiNasionalProvinsi  $intervensiNasionalProvinsi
     * @return \Illuminate\Http\Response
     */
    public function show(IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //
        return view('programs.intervensi_nasional_provinsis.show', compact('intervensiNasionalProvinsi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IntervensiNasionalProvinsi  $intervensiNasionalProvinsi
     * @return \Illuminate\Http\Response
     */
    public function edit(IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //
        return view('programs.intervensi_nasional_provinsis.edit-add', compact('intervensiNasionalProvinsi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IntervensiNasionalProvinsi  $intervensiNasionalProvinsi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //
        $request->validate([
            'ukuran_keberhasilan'  => 'required|min:5'
        ]);

        $intervensiNasionalProvinsi->ukuran_keberhasilan = $request->ukuran_keberhasilan;
        $intervensiNasionalProvinsi->timeline= $request->timeline;
        $intervensiNasionalProvinsi->keterangan = $request->keterangan;
        $intervensiNasionalProvinsi->status = 1;
        $intervensiNasionalProvinsi->save();
        //send notificatio to change leader
        
            $cc = Auth::user();
            $changeLeader = User::where('provinsi_id', $intervensiNasionalProvinsi->provinsi_id)->where('role_id', 2)->first();
            Notification::send($changeLeader, new \App\Notifications\IntervensiNasionalProvinsiSubmitted($intervensiNasionalProvinsi, $cc));
            $success = "penyesuaian berhasil disubmit ke Change leader";
            $info = "email notifikasi telah dikirim ke Change Leader";
            return redirect()->route('programs.index')
                ->with('success', $success)->with('info', $info);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IntervensiNasionalProvinsi  $intervensiNasionalProvinsi
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //
    }

    public function approve(Request $request, IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {

        $intervensiNasionalProvinsi->status = $request->status;
        $intervensiNasionalProvinsi->alasan = $request->alasan;
        $intervensiNasionalProvinsi->save();

        $message = ($intervensiNasionalProvinsi->status == 2) ? 'Berhasil disetujui' : 'Berhasil di tolak';

        return redirect()->route('programs.index')
            ->with('success', $message);
    }
}
