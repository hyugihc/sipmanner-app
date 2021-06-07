<?php

namespace App\Http\Controllers;

use App\ProgressIntervensiNasional;
use Illuminate\Http\Request;
use App\IntervensiNasional;

use Illuminate\Support\Facades\Auth;

class ProgressIntervensiNasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IntervensiNasional $intervensiNasional)
    {
        //
        Auth::user()->cannot('viewAny', ProgressIntervensiNasional::class) ?  abort(403) : true;

        $progressPrograms = (Auth::user()->role_id == 1) ?
            $intervensiNasional->progress_intervensi_nasionals()->paginate(5) : $intervensiNasional->progress_intervensi_nasionals()->where('provinsi_id', Auth::user()->provinsi_id)->paginate(5);

        return view('progress.nasionals.index', compact('intervensiNasional', 'progressPrograms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(IntervensiNasional $intervensiNasional)
    {
        //
        Auth::user()->cannot('create', ProgressIntervensiNasional::class) ?  abort(403) : true;

        return view('progress.nasionals.create', compact('intervensiNasional'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, IntervensiNasional $intervensiNasional)
    {
        //
        Auth::user()->cannot('create', ProgressIntervensiNasional::class) ?  abort(403) : true;

        $progressIntervensiNasional = ProgressIntervensiNasional::create($request->all());
        $progressIntervensiNasional->provinsi_id = Auth::user()->provinsi_id;
        $progressIntervensiNasional->save();


        return redirect()->route('progress_intervensi_nasionals.index', $intervensiNasional)
            ->with('success', 'Progress Programs created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function show(IntervensiNasional $intervensiNasional, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
        Auth::user()->cannot('view', $progressIntervensiNasional) ?  abort(403) : true;

        return view('progress.nasionals.show', compact('intervensiNasional', 'progressIntervensiNasional'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function edit(IntervensiNasional $intervensiNasional, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
        Auth::user()->cannot('update', $progressIntervensiNasional) ?  abort(403) : true;

        return view('progress.nasionals.edit', compact('intervensiNasional', 'progressIntervensiNasional'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntervensiNasional $intervensiNasional, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
        Auth::user()->cannot('update', $progressIntervensiNasional) ?  abort(403) : true;

        $progressIntervensiNasional->update($request->all());

        return redirect()->route('progress_intervensi_nasionals.index', $intervensiNasional)
            ->with('success', 'Progress Program updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntervensiNasional $intervensiNasional, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
        Auth::user()->cannot('delete', $progressIntervensiNasional) ?  abort(403) : true;

        $progressIntervensiNasional->delete();
        return redirect()->route('progress_intervensi_nasionals.index', $intervensiNasional)
            ->with('success', 'Progress program intervensi nasional deleted successfully');
    }
}
