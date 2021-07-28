<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgressIntKhusRequest;
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
        $user = Auth::user();
        if ($user->provinsi_id != $intervensiKhusus->provinsi_id) abort(403);

        if ($user->isChangeLeader() or $user->isTopLeader()) {
            $progressPrograms = $intervensiKhusus->progress_intervensi_khususes()->where("status", "!=", 0)->get();
        }

        if ($user->isChangeChampion() or $user->isAdmin()) {
            $progressPrograms = $intervensiKhusus->progress_intervensi_khususes()->get();
        }

        return view('progress.khususes.index', compact('intervensiKhusus', 'progressPrograms'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(IntervensiKhusus $intervensiKhusus)
    {
        $user = Auth::user();
        if ($user->provinsi_id != $intervensiKhusus->provinsi_id and !$user->isChangeChampion()) abort(403);

        return view('progress.khususes.edit-add', compact('intervensiKhusus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IntervensiKhusus $intervensiKhusus, StoreProgressIntKhusRequest $request)
    {
        $user = Auth::user();
        if ($user->provinsi_id != $intervensiKhusus->provinsi_id and !$user->isChangeChampion()) abort(403);

        $progressIntervensiKhusus = ProgressIntervensiKhusus::create($request->all());
        $progressIntervensiKhusus->intervensi_khusus_id = $intervensiKhusus->id;
        $progressIntervensiKhusus->status = ($request->has('draft')) ? 0 : 1;

        if ($request->has("upload_dokumentasi")) {
            $progressIntervensiKhusus->upload_dokumentasi = $request->file('upload_dokumentasi')->storeAs(
                'piks',
                $progressIntervensiKhusus->getNamaFileDokumentasi()
            );
        }

        if ($request->has("upload_bukti_dukung")) {
            $progressIntervensiKhusus->upload_bukti_dukung = $request->file('upload_bukti_dukung')->storeAs(
                'piks',
                $progressIntervensiKhusus->getNamaFileBuktiDukung()
            );
        }
        $progressIntervensiKhusus->save();

        $message = ($progressIntervensiKhusus->status == 0) ? 'Progress berhasil disimpan menjadi draft' : 'Progress berhasil disubmit ke Change Leader';
        return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
            ->with('success', $message);
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
        Auth::user()->cannot('view',  $progressIntervensiKhusus) ?  abort(403) : true;

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
        Auth::user()->cannot('update',  $progressIntervensiKhusus) ?  abort(403) : true;

        return view('progress.khususes.edit-add', compact('intervensiKhusus', 'progressIntervensiKhusus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgressIntervensiKhusus  $progressIntervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function update(IntervensiKhusus $intervensiKhusus, StoreProgressIntKhusRequest $request,  ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        //
        Auth::user()->cannot('update',  $progressIntervensiKhusus) ?  abort(403) : true;

        $progressIntervensiKhusus->update($request->all());
        $progressIntervensiKhusus->status = ($request->has('draft')) ? 0 : 1;

        if ($request->has("upload_dokumentasi")) {
            if ($progressIntervensiKhusus->upload_dokumentasi != null) {
                Storage::delete($progressIntervensiKhusus->upload_dokumentasi);
            }
            $progressIntervensiKhusus->upload_dokumentasi = $request->file('upload_dokumentasi')->storeAs(
                'piks',
                $progressIntervensiKhusus->getNamaFileDokumentasi()
            );
        }

        if ($request->has("upload_bukti_dukung")) {
            if ($progressIntervensiKhusus->upload_bukti_dukung == null) {
                Storage::delete($progressIntervensiKhusus->upload_bukti_dukung);
            }
            $progressIntervensiKhusus->upload_bukti_dukung = $request->file('upload_bukti_dukung')->storeAs(
                'piks',
                $progressIntervensiKhusus->getNamaFileBuktiDukung()
            );
        }
        $progressIntervensiKhusus->save();

        $message = ($progressIntervensiKhusus->status == 0) ? 'Progress berhasil disimpan menjadi draft' : 'Progress berhasil disubmit ke Change Leader';
        return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
            ->with('success', $message);
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
        Auth::user()->cannot('delete',  $progressIntervensiKhusus) ?  abort(403) : true;
        if ($progressIntervensiKhusus->upload_dokumentasi != null) {
            Storage::delete($progressIntervensiKhusus->upload_dokumentasi);
        }
        if ($progressIntervensiKhusus->upload_bukti_dukung == null) {
            Storage::delete($progressIntervensiKhusus->upload_bukti_dukung);
        }
        $progressIntervensiKhusus->delete();

        $message = "Progres Program berhasil dihapus";
        return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
            ->with('success', $message);
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

    public function approve(Request $request, ProgressIntervensiKhusus $progressIntervensiKhusus)
    {
        Auth::user()->cannot('approve', $progressIntervensiKhusus) ?  abort(403) : true;

        $progressIntervensiKhusus->status = $request->status;
        $progressIntervensiKhusus->alasan = $request->alasan;
        $progressIntervensiKhusus->save();

        $intervensiKhusus = IntervensiKhusus::findOrFail($progressIntervensiKhusus->intervensi_khusus_id);
        $message = ($progressIntervensiKhusus->status == 2) ? 'Progres program berhasil disetujui' : 'Progres program berhasil untuk tidak disetujui';
        return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
            ->with('success', $message);
    }
}
