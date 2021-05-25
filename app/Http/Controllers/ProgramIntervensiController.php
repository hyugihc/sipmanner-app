<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProgramIntervensi;
use App\Pia;
use App\Provinsi;
use Illuminate\Support\Facades\Auth;

class ProgramIntervensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $program_intervensi_nasionals = ProgramIntervensi::where('jenis', 1)->paginate(5);
        $program_intervensis = ProgramIntervensi::where('jenis', 2)->paginate(5);

      //  $program_intervensis = ProgramIntervensi::where('provinsi_id', Auth::user()->provinsi_id)->paginate(5);



        return view('program_intervensis.index', compact('program_intervensi_nasionals', 'program_intervensis'));
    }

    // public function index_progress()
    // {
    //     // $users = User::with(['role', 'provinsi'])->paginate(5);
    //     $program_intervensis = ProgramIntervensi::with(['progress_program'])->paginate(5);
    //     return view('program_intervensis.progress.index', compact('program_intervensis'));
    // }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pias = Pia::all();
        $provinsis = Provinsi::all();
        return view('program_intervensis.create', compact('pias', 'provinsis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $program_intervensi = new ProgramIntervensi();

        //cek policy
      //  if ($request->user()->cannot('create', $program_intervensi)) abort(403);

        //create one
        $program_intervensi = ProgramIntervensi::create($request->all());

        Auth::user()->role_id == 1 ? $program_intervensi->provinsi_id = $request->provinsi_id :
            $program_intervensi->provinsi_id = Auth::user()->provinsi_id;
        $program_intervensi->pias()->attach($request->pias);

        return redirect()->route('program_intervensis.index')
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
        $pias = Pia::all();
        return view('program_intervensis.edit', compact('program_intervensi', 'pias'));
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
        //cek policy
        $request->user()->cannot('update', $program_intervensi) ?
            abort(403) : $program_intervensi->update($request->all());



        return redirect()->route('program_intervensis.index')
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
        return redirect()->route('program_intervensis.index')
            ->with('success', 'Program Intervensi deleted successfully');
    }
}
