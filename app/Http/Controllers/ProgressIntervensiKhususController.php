<?php

namespace App\Http\Controllers;

use App\ProgressIntervensiKhusus;
use App\IntervensiKhusus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

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
        Auth::user()->cannot('viewAny', ProgressIntervensiKhusus::class) ?  abort(403) : true;

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
        Auth::user()->cannot('create', ProgressIntervensiKhusus::class) ?  abort(403) : true;

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
        Auth::user()->cannot('create', ProgressIntervensiKhusus::class) ?  abort(403) : true;

        $request->validate([
            'uraian_program' => 'required|max:50',
            'bulan' => 'required',
            'presentase_program' => 'required',
            'upload_dokumentasi' => 'nullable|mimes:pdf|max:2000',
            'upload_bukti_dukung' => 'nullable|mimes:pdf|max:2000',
            'keterangan' => 'nullable',
        ]);

        $progressIntervensiKhusus = ProgressIntervensiKhusus::create($request->all());

        if ($request->upload_dokumentasi != null) {
            $progressIntervensiKhusus->upload_dokumentasi = $request->file('upload_dokumentasi')->storeAs(
                'piks',
                'pindok_' . $intervensiKhusus->nama . '_' .
                    $request->user()->provinsi_id . '_' . $progressIntervensiKhusus->id . '.pdf'
            );
        }

        if ($request->upload_bukti_dukung != null) {
            $progressIntervensiKhusus->upload_bukti_dukung = $request->file('upload_bukti_dukung')->storeAs(
                'piks',
                'pinduk_' . $intervensiKhusus->nama . '_' .
                    $request->user()->provinsi_id . '_' . $progressIntervensiKhusus->id . '.pdf'
            );
        }


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
    public function show(IntervensiKhusus $intervensiKhusus, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        Auth::user()->cannot('view', $progressIntervensiKhusus) ?  abort(403) : true;

        return view('progress.khususes.show', compact('intervensiKhusus', 'progressIntervensiKhusus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function edit(IntervensiKhusus $intervensiKhusus, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        Auth::user()->cannot('update', $progressIntervensiKhusus) ?  abort(403) : true;

        return view('progress.khususes.edit', compact('intervensiKhusus', 'progressIntervensiKhusus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntervensiKhusus $intervensiKhusus, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        Auth::user()->cannot('update', $progressIntervensiKhusus) ?  abort(403) : true;

        $request->validate([
            'uraian_program' => 'required|max:50',
            'bulan' => 'required',
            'presentase_program' => 'required',
            'upload_dokumentasi' => 'nullable|mimes:pdf|max:2000',
            'upload_bukti_dukung' => 'nullable|mimes:pdf|max:2000',
            'keterangan' => 'nullable',
        ]);

        $progressIntervensiKhusus->update($request->all());

        if ($request->upload_dokumentasi != null) {
            if ($progressIntervensiKhusus->upload_dokumentasi != null) {
                Storage::delete($progressIntervensiKhusus->upload_dokumentasi);
            }
            $progressIntervensiKhusus->upload_dokumentasi = $request->file('upload_dokumentasi')->storeAs(
                'piks',
                'pindok_' . $intervensiKhusus->nama . '_' .
                    $request->user()->provinsi_id . '_' . $progressIntervensiKhusus->id . '.pdf'
            );
        }

        if ($request->upload_bukti_dukung != null) {
            if ($progressIntervensiKhusus->upload_bukti_dukung == null) {
                Storage::delete($progressIntervensiKhusus->upload_bukti_dukung);
            }
            $progressIntervensiKhusus->upload_bukti_dukung = $request->file('upload_bukti_dukung')->storeAs(
                'piks',
                'pinduk_' . $intervensiKhusus->nama . '_' .
                    $request->user()->provinsi_id . '_' . $progressIntervensiKhusus->id . '.pdf'
            );
        }
        $progressIntervensiKhusus->save();

        return redirect()->route('progress_intervensi_khususes.index', $intervensiKhusus)
            ->with('success', 'Progress Program updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntervensiKhusus $intervensiKhusus, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        Auth::user()->cannot('delete', $progressIntervensiKhusus) ?  abort(403) : true;

        $progressIntervensiKhusus->delete();
        return redirect()->route('progress_intervensi_khususes.index', $intervensiKhusus)
            ->with('success', 'Progress program intervensi khusus deleted successfully');
    }

    public function downloadDok(ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        try {
            return Storage::disk('local')->download($progressIntervensiKhusus->upload_dokumentasi);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function downloadDuk(ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        try {
            return Storage::disk('local')->download($progressIntervensiKhusus->upload_bukti_dukung);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
