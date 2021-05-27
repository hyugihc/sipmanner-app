<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProgressProgram;
use App\ProgramIntervensi;
use Illuminate\Support\Facades\Auth;

class ProgressProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progress_programs = ProgressProgram::with(['program_intervensi'])->paginate(5);
        return view('progress_programs.index', compact('progress_programs'));
    }

    public function pi_index()
    {

        $program_intervensi_nasionals = ProgramIntervensi::where('jenis', 1)->paginate(5);
        $program_intervensis = ProgramIntervensi::where('jenis', 2)->paginate(5);

        return view('progress_programs.pi_index', compact('program_intervensi_nasionals', 'program_intervensis'));
    }

    public function ppi_index(ProgramIntervensi $program_intervensi)
    {
        if (Auth::user()->role_id == 1) {
            $progress_programs = $program_intervensi->progress_programs()->paginate(5);
        } else {
            $progress_programs = $program_intervensi->progress_programs()->where('provinsi_id', Auth::user()->provinsi_id)->paginate(5);
        }
        return view('progress_programs.ppi_index', compact('program_intervensi', 'progress_programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $program_intervensis = ProgramIntervensi::all();
        return view('progress_programs.create', compact('program_intervensis'));
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
        $progress_program = ProgressProgram::create($request->all());
        $progress_program->provinsi_id = Auth::user()->provinsi_id;
        $progress_program->save();


        return redirect()->route('pi_index')
            ->with('success', 'Progress Programs created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProgressProgram $progress_program)
    {
        //

        return view('progress_programs.show', compact('progress_program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgressProgram $progress_program)
    {
        //
        return view('progress_programs.edit', compact('progress_program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgressProgram $progress_program)
    {
        //

        //
        $progress_program->update($request->all());

        return redirect()->route('pi_index')
            ->with('success', 'Progress Program updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgressProgram $progress_program)
    {
        $progress_program->delete();
        return redirect()->route('pi_index')
            ->with('success', 'Progress program deleted successfully');
    }
}
