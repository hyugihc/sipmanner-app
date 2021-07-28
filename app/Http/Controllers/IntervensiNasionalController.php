<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIntervensiNasionalRequest;
use App\IntervensiNasional;
use App\Pia;
use App\Provinsi;

class IntervensiNasionalController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(IntervensiNasional::class, 'intervensi_nasional');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $intervensiNasionals = IntervensiNasional::get();
        return view('programs.intervensi_nasionals.index', compact('intervensiNasionals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pias = Pia::all();
        return view('programs.intervensi_nasionals.edit-add', compact('pias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIntervensiNasionalRequest $request)
    {
        //
        $intervensiNasional = IntervensiNasional::create($request->all());
        $intervensiNasional->tahun = date("Y");
        $intervensiNasional->pias()->attach($request->pias);
        $intervensiNasional->status  = ($request->has('draft')) ? 0 : 2;
        $intervensiNasional->save();

        $message = ($intervensiNasional->status == 0) ? 'Program Intervensi Nasional Berhasil disimpan menjadi Draft' : 'Program Intervensi Nasional berhasil di submit';

        return redirect()->route('programs.index')
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function show(IntervensiNasional $intervensiNasional)
    {
        //
        return view('programs.intervensi_nasionals.show', compact('intervensiNasional'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function edit(IntervensiNasional $intervensiNasional)
    {
        //
        $pias = Pia::all();
        $idPia = $intervensiNasional->pias->pluck('id');
        return view('programs.intervensi_nasionals.edit-add', compact('intervensiNasional', 'pias', 'idPia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function update(StoreIntervensiNasionalRequest $request, IntervensiNasional $intervensiNasional)
    {
        //
        $intervensiNasional->update($request->all());
        $intervensiNasional->pias()->sync($request->pias);
        $intervensiNasional->status  = ($request->has('draft')) ? 0 : 2;
        $intervensiNasional->save();

        $message = ($intervensiNasional->status == 0) ? 'Program Intervensi Nasional Berhasil disimpan menjadi Draft' : 'Program Intervensi Nasional berhasil di submit';

        return redirect()->route('programs.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntervensiNasional $intervensiNasional)
    {
        //
        $intervensiNasional->pias()->detach();
        $intervensiNasional->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Nasional berhasil dihapus');
    }
}
