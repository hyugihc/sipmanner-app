<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProgramIntervensi;
use App\Pia;

class ProgramIntervensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $program_intervensi = ProgramIntervensi::paginate(5);
        return view('programintervensi.index', compact('$program_intervensi'));
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
        return view('programintervensi.create', compact('pias'));
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
        ProgramIntervensi::create($request->all());

        return redirect()->route('program_intervensi.index')
            ->with('success', 'Program Intervensi created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramIntervensi $program_intervensi)
    {
        //
        return view('program_intervensis.show', compact('program_intervensi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramIntervensi $program_intervensi)
    {
        //
        return view('program_intervensis.edit', compact('program_intervensi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramIntervensi $program_intervensi)
    {
        //
        $program_intervensi->update($request->all());

        return redirect()->route('programintervensis.index')
            ->with('success', 'Program Intervensi updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramIntervensi $program_intervensi)
    {
        //
        //
        $program_intervensi->delete();
        return redirect()->route('programintervensis.index')
            ->with('success', 'Program Intervensi deleted successfully');
    }
}
