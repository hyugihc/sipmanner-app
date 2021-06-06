<?php

namespace App\Http\Controllers;

use App\ProgressIntervensiKhusus;
use App\IntervensiKhusus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressIntervensiKhususController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IntervensiKhusus $intervensiKhusus)
    {
        //
        $progressPrograms = $intervensiKhusus->progress_intervensi_khususes()->paginate(5);

        return view('progress.khususes.index', compact('intervensiKhusus', 'progressPrograms'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(IntervensiKhusus $intervensiKhusus)
    {
        //
        return view('progress.khususes.create', compact('intervensiKhusus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, IntervensiKhusus $intervensiKhusus)
    {
        //
        $progressIntervensiKhusus = ProgressIntervensiKhusus::create($request->all());
        $progressIntervensiKhusus->save();


        return redirect()->route('progress_intervensi_khususes.index', $intervensiKhusus)
            ->with('success', 'Progress Programs created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function show(IntervensiKhusus $intervensiKhusus,ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        return view('progress.khususes.show', compact('intervensiKhusus', 'progressIntervensiKhusus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function edit(IntervensiKhusus $intervensiKhusus,ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        return view('progress.khususes.edit', compact('intervensiKhusus','progressIntervensiKhusus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,IntervensiKhusus $intervensiKhusus, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        $progressIntervensiKhusus->update($request->all());

        return redirect()->route('progress_intervensi_khususes.index', $intervensiKhusus)
            ->with('success', 'Progress Program updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function destroy( IntervensiKhusus $intervensiKhusus,ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        $progressIntervensiKhusus->delete();
        return redirect()->route('progress_intervensi_khususes.index',$intervensiKhusus)
            ->with('success', 'Progress program intervensi khusus deleted successfully');
    }
}
