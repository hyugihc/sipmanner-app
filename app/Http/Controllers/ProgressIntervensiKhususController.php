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


        return redirect()->route('progress_intervensi_khususes', $intervensiKhusus)
            ->with('success', 'Progress Programs created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function show(ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
    }
}
