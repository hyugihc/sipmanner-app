<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgressIntKhusRequest;
use App\ProgressIntervensiKhusus;
use App\IntervensiKhusus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
//use notif progressInKusSubmittedToCL
use App\Notifications\ProgressInKusSubmittedToCL;
// Log
use Illuminate\Support\Facades\Log;

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

        //if ($user->provinsi_id != $intervensiKhusus->provinsi_id and !$user->isChangeChampion()) abort(403);

        //abort jika user bukan change champion dan user_id tidak sama dengan intervensi khusus user_id
        if (!$user->isChangeChampion()) abort(403, "anda bukan change champions");
        if ($intervensiKhusus->user_id != $user->id) abort(403, "Anda bukan pembuat rencana aksi");



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

        if ($progressIntervensiKhusus->status == 1) {
            if ($this->getLastProgressIntervensiKhusus($intervensiKhusus)) {
                $lastProgressIntervensiKhusus = $this->getLastProgressIntervensiKhusus($intervensiKhusus);
                // bandingkan tanggal, jika lebih kecil maka simpan sebagai draft dan kembali ke index
                if ($lastProgressIntervensiKhusus->tanggal >= $progressIntervensiKhusus->tanggal) {
                    $progressIntervensiKhusus->status = 0;
                    $progressIntervensiKhusus->save();
                    return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
                        ->with('error', 'Tanggal yang diinputkan lebih kecil atau sama dengan dari Tanggal sebelumnya');
                }
                // bandingkan realisasi pelaksanaan kegiatan, jika lebih kecil maka simpan sebagai draft dan kembali ke index
                if ($lastProgressIntervensiKhusus->realisasi_pelaksanaan_kegiatan >= $progressIntervensiKhusus->realisasi_pelaksanaan_kegiatan) {
                    $progressIntervensiKhusus->status = 0;
                    $progressIntervensiKhusus->save();
                    return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
                        ->with('error', 'Realisasi Pelaksanaan Kegiatan yang diinputkan lebih kecil atau sama dengan dari Realisasi Pelaksanaan Kegiatan sebelumnya');
                }
                // bandingkan realisasi capaian keberhasilan, jika lebih kecil maka simpan sebagai draft dan kembali ke index
                if ($lastProgressIntervensiKhusus->realisasi_capaian_keberhasilan > $progressIntervensiKhusus->realisasi_capaian_keberhasilan) {
                    $progressIntervensiKhusus->status = 0;
                    $progressIntervensiKhusus->save();
                    return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
                        ->with('error', 'Realisasi Capaian Kebahasilan yang diinputkan lebih kecil atau sama dengan dari Realisasi Capaian Kebahasilan sebelumnya');
                }
            }
        }
        $progressIntervensiKhusus->save();

        if ($progressIntervensiKhusus->status == 1) {
            $message = 'Progress berhasil disubmit ke Change Leader';
            //notify change leader
            try {
                $changeLeader = $intervensiKhusus->getChangeLeader();
                $changeLeader->notify(new ProgressInKusSubmittedToCL($intervensiKhusus, $progressIntervensiKhusus));
                $info = 'email notifikasi telah dikirim ke Change Leader';
                return redirect()->to(config('app.url') . '/progress')
                    ->with('success', $message)->with('info', $info);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $warning = 'email notifikasi gagal dikirim ke Change Leader';
                return redirect()->to(config('app.url') . '/progress')
                    ->with('success', $message)->with('warning', $warning);
            }
        } elseif ($progressIntervensiKhusus->status == 0) {
            $message = 'Progress berhasil disimpan menjadi draft';
            return redirect()->to(config('app.url') . '/progress')
                ->with('success', $message);
        }
    }

    // ambil progress intervensi khusus terakhir
    public function getLastProgressIntervensiKhusus(IntervensiKhusus $intervensiKhusus)
    {
        $progressIntervensiKhusus = $intervensiKhusus->progress_intervensi_khususes()->where("status", "!=", 0)->orderBy("tanggal", "desc")->first();
        return $progressIntervensiKhusus;
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
        if ($progressIntervensiKhusus->status == 1) {
            if ($this->getLastProgressIntervensiKhusus($intervensiKhusus)) {
                $lastProgressIntervensiKhusus = $this->getLastProgressIntervensiKhusus($intervensiKhusus);
                // bandingkan tanggal, jika lebih kecil maka simpan sebagai draft dan kembali ke index
                if ($lastProgressIntervensiKhusus->tanggal > $progressIntervensiKhusus->tanggal) {
                    $progressIntervensiKhusus->status = 0;
                    $progressIntervensiKhusus->save();
                    return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
                        ->with('error', 'Tanggal yang diinputkan lebih kecil atau sama dengan dari Tanggal sebelumnya');
                }
                // bandingkan realisasi pelaksanaan kegiatan, jika lebih kecil maka simpan sebagai draft dan kembali ke index
                if ($lastProgressIntervensiKhusus->realisasi_pelaksanaan_kegiatan >= $progressIntervensiKhusus->realisasi_pelaksanaan_kegiatan) {
                    $progressIntervensiKhusus->status = 0;
                    $progressIntervensiKhusus->save();
                    return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
                        ->with('error', 'Realisasi Pelaksanaan Kegiatan yang diinputkan lebih kecil atau sama dengan dari Realisasi Pelaksanaan Kegiatan sebelumnya');
                }
                // bandingkan realisasi capaian keberhasilan, jika lebih kecil maka simpan sebagai draft dan kembali ke index
                if ($lastProgressIntervensiKhusus->realisasi_capaian_keberhasilan >= $progressIntervensiKhusus->realisasi_capaian_keberhasilan) {
                    $progressIntervensiKhusus->status = 0;
                    $progressIntervensiKhusus->save();
                    return redirect()->route('intervensi-khususes.progress-intervensi-khususes.index', $intervensiKhusus)
                        ->with('error', 'Realisasi Capaian Kebahasilan yang diinputkan lebih kecil atau sama dengan dari Realisasi Capaian Kebahasilan sebelumnya');
                }
            }
        }
        $progressIntervensiKhusus->save();

        if ($progressIntervensiKhusus->status == 1) {
            $message = 'Progress berhasil disubmit ke Change Leader';
            //notify change leader

            try {
                $changeLeader = $intervensiKhusus->getChangeLeader();
                $changeLeader->notify(new ProgressInKusSubmittedToCL($intervensiKhusus, $progressIntervensiKhusus));
                $info = 'email notifikasi telah dikirim ke Change Leader';
                return redirect()->to(config('app.url') . '/progress')
                    ->with('success', $message)->with('info', $info);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $warning = 'email notifikasi gagal dikirim ke Change Leader';
                return redirect()->to(config('app.url') . '/progress')
                    ->with('success', $message)->with('warning', $warning);
            }
        } elseif ($progressIntervensiKhusus->status == 0) {
            $message = 'Progress berhasil disimpan menjadi draft';
            return redirect()->to(config('app.url') . '/progress')
                ->with('success', $message);
        }
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
