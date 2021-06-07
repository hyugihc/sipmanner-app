<?php

namespace App\Http\Controllers;

use App\IntervensiNasional;
use App\Pia;
use App\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntervensiNasionalController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Auth::user()->cannot('viewAny', IntervensiNasional::class) ?  abort(403) : true;

        $intervensiNasionals = IntervensiNasional::paginate(5);
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
        Auth::user()->cannot('create', IntervensiNasional::class) ?  abort(403) : true;

        $pias = Pia::all();
        $provinsis = Provinsi::all();
        return view('programs.intervensi_nasionals.create', compact('pias', 'provinsis'));
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
        Auth::user()->cannot('create', IntervensiNasional::class) ?  abort(403) : true;

        $request->validate([
            'nama' => 'required|min:3|max:50',
            'uraian_kegiatan' => 'required|max:50',
            'volume' => 'required',
            'output' => 'required',
            'outcome' => 'required',
            'keterangan' => 'required',
            'pias' => 'required',
        ]);


        $intervensiNasional = IntervensiNasional::create($request->all());
        $intervensiNasional->pias()->attach($request->pias);
        $intervensiNasional->status = 1;
        $intervensiNasional->save();


        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Nasional created successfully.');
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
        Auth::user()->cannot('view', $intervensiNasional) ?  abort(403) : true;

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
        Auth::user()->cannot('update', $intervensiNasional) ?  abort(403) : true;

        $pias = Pia::all();
        return view('programs.intervensi_nasionals.edit', compact('intervensiNasional', 'pias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IntervensiNasional  $intervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntervensiNasional $intervensiNasional)
    {
        //
        Auth::user()->cannot('update', $intervensiNasional) ?  abort(403) : true;

        $request->validate([
            'nama' => 'required|min:3|max:50',
            'uraian_kegiatan' => 'required|max:50',
            'volume' => 'required',
            'output' => 'required',
            'outcome' => 'required',
            'keterangan' => 'required',
            'pias' => 'required',
        ]);

        $intervensiNasional->update($request->all());
        $intervensiNasional->pias()->sync($request->pias);
        $intervensiNasional->save();

        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Nasional updated successfully');
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
        Auth::user()->cannot('delete', $intervensiNasional) ?  abort(403) : true;

        $intervensiNasional->delete();
        
        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Nasional deleted successfully');
    }
}
