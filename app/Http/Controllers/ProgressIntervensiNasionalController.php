<?php

namespace App\Http\Controllers;

use App\ProgressIntervensiNasional;
use Illuminate\Http\Request;
use App\IntervensiNasional;
use App\IntervensiNasionalProvinsi;
use Illuminate\Support\Facades\Storage;
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

        $intervensiNasionalProvinsi = IntervensiNasionalProvinsi::where('provinsi_id', Auth::user()->provinsi_id)->where('intervensi_nasional_id', $intervensiNasional->id)->first();
        if ($intervensiNasionalProvinsi == null) {
            $intervensiNasionalProvinsi =  new IntervensiNasionalProvinsi();
            $intervensiNasionalProvinsi->provinsi_id = Auth::user()->provinsi_id;
            $intervensiNasionalProvinsi->intervensi_nasional_id = $intervensiNasional->id;
            $intervensiNasionalProvinsi->save();
        }

        $progressPrograms = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $intervensiNasionalProvinsi->id)->paginate(5);

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

        $request->validate([
            'uraian_program' => 'required|max:500',
            'bulan' => 'required',
            'presentase_program' => 'required',
            'upload_dokumentasi' => 'nullable|mimes:pdf|max:2000',
            'upload_bukti_dukung' => 'nullable|mimes:pdf|max:2000',
            'keterangan' => 'nullable',
        ]);


        $intervensiNasionalProvinsi = IntervensiNasionalProvinsi::where('provinsi_id', Auth::user()->provinsi_id)->where('intervensi_nasional_id', $intervensiNasional->id)->first();

        $progressIntervensiNasional = ProgressIntervensiNasional::create($request->all());
        $progressIntervensiNasional->intervensi_nasional_provinsi_id = $intervensiNasionalProvinsi->id;

        if ($request->upload_dokumentasi != null) {
            $progressIntervensiNasional->upload_dokumentasi = $request->file('upload_dokumentasi')->storeAs(
                'pins',
                'pindok_' . $intervensiNasional->id . '_' .
                    $request->user()->provinsi_id . '_' . $progressIntervensiNasional->id . '.pdf'
            );
        }

        if ($request->upload_bukti_dukung != null) {
            $progressIntervensiNasional->upload_bukti_dukung = $request->file('upload_bukti_dukung')->storeAs(
                'pins',
                'pinduk_' . $intervensiNasional->id . '_' .
                    $request->user()->provinsi_id . '_' . $progressIntervensiNasional->id . '.pdf'
            );
        }

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

        $request->validate([
            'uraian_program' => 'required|max:50',
            'bulan' => 'required',
            'presentase_program' => 'required',
            'upload_dokumentasi' => 'nullable|mimes:pdf|max:2000',
            'upload_bukti_dukung' => 'nullable|mimes:pdf|max:2000',
            'keterangan' => 'nullable',
        ]);

        $progressIntervensiNasional->update($request->all());

        if ($request->upload_dokumentasi != null) {
            if ($progressIntervensiNasional->upload_dokumentasi != null) {
                Storage::delete($progressIntervensiNasional->upload_dokumentasi);
            }
            $progressIntervensiNasional->upload_dokumentasi = $request->file('upload_dokumentasi')->storeAs(
                'pins',
                'pindok_' . $intervensiNasional->id . '_' .
                    $request->user()->provinsi_id . '_' . $progressIntervensiNasional->id . '.pdf'
            );
        }

        if ($request->upload_bukti_dukung != null) {
            if ($progressIntervensiNasional->upload_bukti_dukung != null) {
                Storage::delete($progressIntervensiNasional->upload_bukti_dukung);
            }
            $progressIntervensiNasional->upload_bukti_dukung = $request->file('upload_bukti_dukung')->storeAs(
                'pins',
                'pinduk_' . $intervensiNasional->id . '_' .
                    $request->user()->provinsi_id . '_' . $progressIntervensiNasional->id . '.pdf'
            );
        }
        $progressIntervensiNasional->save();

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

    public function downloadDok(ProgressIntervensiNasional $progressIntervensiNasional)
    {
        try {
            return Storage::disk('local')->download($progressIntervensiNasional->upload_dokumentasi);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function downloadDuk(ProgressIntervensiNasional $progressIntervensiNasional)
    {
        try {
            return Storage::disk('local')->download($progressIntervensiNasional->upload_bukti_dukung);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
