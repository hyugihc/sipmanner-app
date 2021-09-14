<?php

namespace App\Http\Controllers;

use App\IntervensiNasionalProvinsi;
use Illuminate\Http\Request;

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
        $intervensiNasionalProvinsi->status = 1;
        $intervensiNasionalProvinsi->save();

        return redirect()->route('programs.index')
            ->with('success', "penyesuaian berhasil disubmit ke Change leader");
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
