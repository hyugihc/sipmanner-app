<?php

namespace App\Http\Controllers;

use App\IntervensiKhusus;
use Illuminate\Http\Request;
use App\Pia;
use App\Provinsi;
use Illuminate\Support\Facades\Auth;

class IntervensiKhususController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $intervensiKhususes = (Auth::user()->role_id == 1) ?
            IntervensiKhusus::paginate(5) : IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->paginate(5);
        return view('intervensi_khususes.index', compact('intervensiKhususes'));
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
        $provinsis = Provinsi::all();
        return view('intervensi_khususes.create', compact('pias', 'provinsis'));
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
        $request->validate([
            'nama' => 'required|min:3|max:50',
            'uraian_kegiatan' => 'required|max:50',
            'volume' => 'required',
            'output' => 'required',
            'outcome' => 'required',
            'keterangan' => 'required',
            'pias' => 'required',
        ]);


        $intervensi = IntervensiKhusus::create($request->all());
        $intervensi->provinsi_id = ($request->user()->role_id == 1)  ? $request->provinsi_id :
            $request->user()->provinsi_id;
        $intervensi->pias()->attach($request->pias);
        $intervensi->status = 1;
        $intervensi->save();


        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Khusus created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function show(IntervensiKhusus $intervensiKhusus)
    {
        //
        return view('intervensi_khususes.show', compact('intervensiKhusus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function edit(IntervensiKhusus $intervensiKhusus)
    {
        //
        $pias = Pia::all();
        $provinsis = Provinsi::all();
        return view('intervensi_khususes.edit', compact('intervensiKhusus', 'pias', 'provinsis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntervensiKhusus $intervensiKhusus)
    {
        //
        $request->validate([
            'nama' => 'required|min:3|max:50',
            'uraian_kegiatan' => 'required|max:50',
            'volume' => 'required',
            'output' => 'required',
            'outcome' => 'required',
            'keterangan' => 'required',
            'pias' => 'required',
        ]);

        $intervensiKhusus->update($request->all());
        $intervensiKhusus->provinsi_id = ($request->user()->role_id == 1)  ? $request->provinsi_id :
            $request->user()->provinsi_id;
        $intervensiKhusus->pias()->sync($request->pias);
        $intervensiKhusus->save();

        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Khusus updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntervensiKhusus $intervensiKhusus)
    {
        //
        $intervensiKhusus->delete();
        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Khusus deleted successfully');
    }
}
