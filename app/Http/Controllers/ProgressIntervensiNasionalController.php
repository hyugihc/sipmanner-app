<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgressIntNasRequest;
use App\ProgressIntervensiNasional;
use Illuminate\Http\Request;
use App\IntervensiNasional;
use App\IntervensiNasionalProvinsi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
//define user
use App\User;
//define ProgressInNaSubmittedToCL
use App\Notifications\ProgressInNasSubmittedToCL;

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
        $user = Auth::user();
        $user->cannot('viewAny', ProgressIntervensiNasional::class) ?  abort(403) : true;

        $intervensiNasionalProvinsi = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->where('intervensi_nasional_id', $intervensiNasional->id)->first();

        if ($user->isChangeLeader()) {
            $progressPrograms = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $intervensiNasionalProvinsi->id)->where("status", "!=", 0)->get();
        }

        if ($user->isChangeChampion()) {
            $progressPrograms = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $intervensiNasionalProvinsi->id)->get();
        }

        if ($user->isAdmin()) {
            $intervensiNasionalProvinsi = IntervensiNasionalProvinsi::where('intervensi_nasional_id', $intervensiNasional->id)->first();
            $progressPrograms = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $intervensiNasionalProvinsi->id)->get();
        }


        return view('progress.nasionals.index', compact('intervensiNasional', 'progressPrograms'));
    }

    //index2
    public function index2(IntervensiNasionalProvinsi $intervensiNasionalProvinsi)
    {
        //ambil intervensi nasional dari intervensi nasional provinsi ini
        $intervensiNasional = $intervensiNasionalProvinsi->intervensiNasional;
        //tampilkan progres intervensi nasional provinsi ini
        $progressPrograms = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $intervensiNasionalProvinsi->id)->get();
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

        return view('progress.nasionals.edit-add', compact('intervensiNasional'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IntervensiNasional $intervensiNasional, StoreProgressIntNasRequest $request)
    {
        //
        Auth::user()->cannot('create', ProgressIntervensiNasional::class) ?  abort(403) : true;

        $intervensiNasionalProvinsi = IntervensiNasionalProvinsi::where('provinsi_id', Auth::user()->provinsi_id)->where('intervensi_nasional_id', $intervensiNasional->id)->first();
        $progressIntervensiNasional = ProgressIntervensiNasional::create($request->all());
        $progressIntervensiNasional->status = ($request->has('draft')) ? 0 : 1;
        $progressIntervensiNasional->intervensi_nasional_provinsi_id = $intervensiNasionalProvinsi->id;
        $progressIntervensiNasional->save();
        if ($request->has("upload_bukti_dukung")) {
            $progressIntervensiNasional->upload_bukti_dukung = $request->file('upload_bukti_dukung')->storeAs(
                'pins',
                $progressIntervensiNasional->getNamaFileBuktiDukung()
            );
        }

        // if ($progressIntervensiNasional->status == 1) {
        //     $intervensiNasionalProvinsi = $this->getIntervensiNasionalProvinsi();
        //     if ($this->getLastProgressIntervensiNasionalProvinsi($intervensiNasionalProvinsi)) {
        //         $lastProgressIntervensiNasionalProvinsi = $this->getLastProgressIntervensiNasionalProvinsi($intervensiNasionalProvinsi);
        //         //bandingkan bulan

        //         if ($lastProgressIntervensiNasionalProvinsi->bulan >= $progressIntervensiNasional->bulan) {
        //             $progressIntervensiNasional->status = 0;
        //             $progressIntervensiNasional->save();
        //             return redirect()->route('intervensi-nasionals.progress-intervensi-nasionals.index', $intervensiNasional)
        //                 ->with('error', 'Bulan yang diinputkan lebih kecil atau sama dengan dari bulan sebelumnya');

        //             // return back()
        //             //     ->withInput($request->input())
        //             //     ->withErrors([
        //             //         'bulan' => 'Bulan yang diinputkan lebih kecil atau sama dengan dari bulan sebelumnya',
        //             //     ]);
        //         }
        //         //bandingkan progress
        //         if ($lastProgressIntervensiNasionalProvinsi->realisasi_pelaksanaan_kegiatan  >= $progressIntervensiNasional->realisasi_pelaksanaan_kegiatan) {
        //             $progressIntervensiNasional->status = 0;
        //             $progressIntervensiNasional->save();
        //             return redirect()->route('intervensi-nasionals.progress-intervensi-nasionals.index', $intervensiNasional)
        //                 ->with('error', 'Progress yang diinputkan lebih kecil atau sama dengan dari bulan sebelumnya');

        //             // return back()
        //             //     ->withInput($request->input())
        //             //     ->withErrors([
        //             //         'realisasi_pelaksanaan_kegiatan' => 'Progres yang diinputkan lebih kecil atau sama dengan dari bulan sebelumnya',
        //             //     ]);
        //         }
        //     }
        // }

        $progressIntervensiNasional->save();

        if ($progressIntervensiNasional->status == 1) {
            $message = 'Progress berhasil di input';
            $info = 'Terima kasih atas pelaporanya';
            return redirect()->to(config('app.url') . '/progress')->with('success', $message)->with('info', $info);
        } elseif ($progressIntervensiNasional->status == 0) {
            $message = 'Progress berhasil disimpan menjadi draft';
            return redirect()->to(config('app.url') . '/progress')
                ->with('success', $message);
        }
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

        return view('progress.nasionals.edit-add', compact('intervensiNasional', 'progressIntervensiNasional'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgressIntervensiNasional  $progressIntervensiNasional
     * @return \Illuminate\Http\Response
     */
    public function update(IntervensiNasional $intervensiNasional, StoreProgressIntNasRequest $request, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        //
        Auth::user()->cannot('update', $progressIntervensiNasional) ?  abort(403) : true;

        $progressIntervensiNasional->update($request->all());



        if ($request->has("upload_bukti_dukung")) {
            if ($progressIntervensiNasional->upload_bukti_dukung != null) {
                Storage::delete($progressIntervensiNasional->upload_bukti_dukung);
            }
            $progressIntervensiNasional->upload_bukti_dukung = $request->file('upload_bukti_dukung')->storeAs(
                'pins',
                $progressIntervensiNasional->getNamaFileBuktiDukung()
            );
        }

        $progressIntervensiNasional->status = ($request->has('draft')) ? 0 : 1;
        // if ($progressIntervensiNasional->status == 1) {
        //     $intervensiNasionalProvinsi = $this->getIntervensiNasionalProvinsi();
        //     if ($this->getLastProgressIntervensiNasionalProvinsi($intervensiNasionalProvinsi)) {
        //         $lastProgressIntervensiNasionalProvinsi = $this->getLastProgressIntervensiNasionalProvinsi($intervensiNasionalProvinsi);
        //         //bandingkan bulan

        //         if ($lastProgressIntervensiNasionalProvinsi->bulan >= $progressIntervensiNasional->bulan) {
        //             $progressIntervensiNasional->status = 0;
        //             $progressIntervensiNasional->save();
        //             return redirect()->route('intervensi-nasionals.progress-intervensi-nasionals.index', $intervensiNasional)
        //                 ->with('error', 'Bulan yang diinputkan lebih kecil atau sama dengan dari bulan sebelumnya');

        //             // return back()
        //             //     ->withInput($request->input())
        //             //     ->withErrors([
        //             //         'bulan' => 'Bulan yang diinputkan lebih kecil atau sama dengan dari bulan sebelumnya',
        //             //     ]);
        //         }
        //         //bandingkan progress
        //         if ($lastProgressIntervensiNasionalProvinsi->realisasi_pelaksanaan_kegiatan >= $progressIntervensiNasional->realisasi_pelaksanaan_kegiatan) {
        //             $progressIntervensiNasional->status = 0;
        //             $progressIntervensiNasional->save();
        //             return redirect()->route('intervensi-nasionals.progress-intervensi-nasionals.index', $intervensiNasional)
        //                 ->with('error', 'Progress yang diinputkan lebih kecil atau sama dengan dari bulan sebelumnya');

        //             // return back()
        //             //     ->withInput($request->input())
        //             //     ->withErrors([
        //             //         'realisasi_pelaksanaan_kegiatan' => 'Progres yang diinputkan lebih kecil atau sama dengan dari bulan sebelumnya',
        //             //     ]);
        //         }
        //     }
        // }

        $progressIntervensiNasional->save();

        if ($progressIntervensiNasional->status == 1) {
            $message = 'Progress berhasil di input';
            $info = 'Terima kasih atas pelaporanya';
            return redirect()->to(config('app.url') . '/progress')->with('success', $message)->with('info', $info);
        } elseif ($progressIntervensiNasional->status == 0) {
            $message = 'Progress berhasil disimpan menjadi draft';
            return redirect()->to(config('app.url') . '/progress')
                ->with('success', $message);
        }
    }

    //get Intervensi Nasional Provinsi dari user
    public function getIntervensiNasionalProvinsi()
    {
        $intervensiNasionalProvinsi = IntervensiNasionalProvinsi::where('provinsi_id', Auth::user()->provinsi_id)->first();
        return $intervensiNasionalProvinsi;
    }


    //ambil progress intervensi nasional dengan bulan terbesar jika ada
    public function getLastProgressIntervensiNasionalProvinsi($intervensiNasionalProvinsi)
    {
        $progressIntervensiNasional = ProgressIntervensiNasional::where('intervensi_nasional_provinsi_id', $intervensiNasionalProvinsi->id)->where('status', '!=', '0')->orderBy('bulan', 'desc')->first();
        return $progressIntervensiNasional;
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

        if ($progressIntervensiNasional->upload_dokumentasi != null) {
            Storage::delete($progressIntervensiNasional->upload_dokumentasi);
        }
        if ($progressIntervensiNasional->upload_bukti_dukung != null) {
            Storage::delete($progressIntervensiNasional->upload_bukti_dukung);
        }
        $progressIntervensiNasional->delete();

        $message = 'Progres program berhasil dihapus';
        return redirect()->route('intervensi-nasionals.progress-intervensi-nasionals.index', $intervensiNasional)
            ->with('success', $message);
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

    public function approve(Request $request, ProgressIntervensiNasional $progressIntervensiNasional)
    {
        Auth::user()->cannot('approve', $progressIntervensiNasional) ?  abort(403) : true;
        $progressIntervensiNasional->status = $request->status;
        $progressIntervensiNasional->alasan = $request->alasan;
        $progressIntervensiNasional->save();

        $message = ($progressIntervensiNasional->status == 2) ? 'Progres program berhasil disetujui' : 'Progres program berhasil untuk tidak disetujui';
        return redirect()->route('progress.index')
            ->with('success', $message);
    }
}
