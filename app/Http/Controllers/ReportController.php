<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\IntervensiKhusus;
use App\IntervensiNasional;
use App\IntervensiNasionalProvinsi;
use App\Report;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;
//define Notification
use Illuminate\Support\Facades\Notification;
//define ReportSubmittedToCL
use App\Notifications\ReportSubmittedToCL;
//define log
use Illuminate\Support\Facades\Log;


class ReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //list report yang ada bedakan berdasarkan role
        $user = Auth::user();
        $year = $user->getSetting('tahun');

        //untuk CC
        if ($user->isChangeChampion()) {
            $reports = Report::where('provinsi_id', $user->provinsi_id)->where('tahun', $year)->get();
        }
        //untuk CL
        if ($user->isChangeLeader()) {
            $clStatus = [1, 2, 4];
            $reports = Report::where('provinsi_id', $user->provinsi_id)->whereIn('status', $clStatus)->where('tahun', $year)->get();
        }
        //untuk admin
        if ($user->isAdmin()) {
            $reports = Report::where('tahun', $year)->get();
        }

        if ($year == 2021) {
            return view('reports.2021-index', compact('reports'));
        }

        return view('reports.index', compact('reports'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLaporan($tahun, $semester)
    {
        //jika sudah ada laporan kembalikan warning
        $user = Auth::user();
        if (Report::where('provinsi_id', $user->provinsi_id)->where('tahun', $tahun)->where('semester', $semester)->first()) {
            return redirect()->route('reports.index')
                ->with('warning', "Laporan sudah ada");
        }

        //jika belum ada create laporan
        $report = new Report();
        $report->tahun = $tahun;
        $report->semester = $semester;
        $report->provinsi_id = $user->provinsi_id;
        $report->status == 0;
        $report->save();

        //attach intervensi nasional pada report masih sesuai
        $intervensiNasionals = $this->getIntervensiNasionalForReport($report);
        $report->intervensiNasionalProvinsis()->sync($intervensiNasionals);

        //attach intervensi khusus
        $intervensiKhususes = $this->getIntervensiKhususForReport($report);
        if ($intervensiKhususes != null) {
            $report->intervensiKhususes()->sync($intervensiKhususes);
        }

        //attach report dengan CCnya
        $changeChampions = User::where('role_id', 3)->where('provinsi_id', $user->provinsi_id)->get();
        $report->changeChampions()->attach($changeChampions, ['status' => 0]);



        //kembali ke index
        return redirect()->route('reports.index')
            ->with('success', "Laporan berhasil dibuat");
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        $user = Auth::user();

        return view('reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(StoreReportRequest $request, Report $report)
    {
        //
        $user = Auth::user();
        $report->update($request->all());
        //update last modified
        $report->user_id = $user->id;
        //simpan file
        if ($request->has("lampiran")) {
            $report->lampiran != null ? Storage::delete($report->lampiran) : true;
            $report->lampiran = $request->file('lampiran')->storeAs('lampiran-laporan', $report->getNamaFileLampiran());
        }
        //isi kendala dan solusi masng2 program
        foreach ($report->intervensiNasionalProvinsis as $inp) {
            $report->intervensiNasionalProvinsis()->detach($inp);
            $report->intervensiNasionalProvinsis()->attach($inp, ['kendala' => $request->intervensiNasional_kendala[$inp->id], 'solusi' => $request->intervensiNasional_solusi[$inp->id]]);
        }
        foreach ($report->intervensiKhususes as $ik) {
            $report->intervensiKhususes()->detach($ik->id);
            $report->intervensiKhususes()->attach($ik->id, ['kendala' => $request->intervensiKhusus_kendala[$ik->id], 'solusi' => $request->intervensiKhusus_solusi[$ik->id]]);
        }
        //perbarui persetujuan jika di cek maupun di uncek
        //cek apakah ada centang
        if ($request->changeChampions != null) {
            if ($request->changeChampions[$user->id] != null) {
                //jika di cek
                $report->changeChampions()->syncWithoutDetaching([$user->id => ['status' => 2]]);
            } else {
                //jika di uncek
                $report->changeChampions()->syncWithoutDetaching([$user->id => ['status' => 0]]);
            }
        }
        //update CC yang terbaru
        $changeChampions = User::where('role_id', 3)->where('provinsi_id', $user->provinsi_id)->get();
        $report->changeChampions()->sync($changeChampions);

        if ($request->has("submit")) {
            //kalau sudah submit kendala dan solusi tidak boleh kosong
            foreach ($report->intervensiNasionalProvinsis as $inp) {
                if ($request->intervensiNasional_kendala[$inp->id] == null or $request->intervensiNasional_solusi[$inp->id] == null) {
                    $report->status = 0;
                    $report->save();
                    return redirect()->route('reports.edit', $report)->with('success', 'Laporan berhasil disimpan')
                        ->with('warning', "Laporan belum berhasi disubmit, masih ada kendala atau solusi program belum terisi");
                }
            }
            foreach ($report->intervensiKhususes as $ik) {
                if ($request->intervensiKhusus_kendala[$ik->id] == null or $request->intervensiKhusus_solusi[$ik->id] == null) {
                    $report->status = 0;
                    $report->save();
                    return redirect()->route('reports.edit', $report)->with('success', 'Laporan berhasil disimpan')
                        ->with('warning', "Laporan belum berhasi disubmit, masih ada kendala atau solusi program belum terisi");
                }
            }

            //pastikan semua cc terbaru tercentang
            foreach ($changeChampions as $changeChampion) {
                if ($report->changeChampions()->where('id', $changeChampion->id)->first()->pivot->status != 2) {
                    $report->status = 0;
                    $report->save();
                    return redirect()->route('reports.edit', $report)->with('success', 'Laporan berhasil disimpan')
                        ->with('warning', "Laporan belum berhasi disubmit, masih ada CC yang belum setuju");
                }
            }
            $report->status = 1;
            $report->save();
            //kirim email ke change leader
           
            try {
                $changeLeader = User::where('role_id', 2)->where('provinsi_id', $user->provinsi_id)->first();
                Notification::send($changeLeader, new ReportSubmittedToCL($report));
                $message = 'Laporan berhasil disubmit ke Change Leader';
                $info = 'Email notifikasi telah dikirim ke Change Leader';
                return redirect()->route('reports.index')
                    ->with('success', $message)->with('info', $info);
            } catch (\Exception $e) {
                //catatkan di log
                Log::error($e->getMessage());
                return redirect()->route('reports.edit', $report)->with('success', 'Laporan berhasil disimpan')
                    ->with('warning', "Laporan berhasil disubmit, namun email ke change leader gagal dikirim");
            }
        } else {
            $report->status = 0;
            $report->save();
            $message = 'Laporan berhasil disimpan menjadi draft';
            return redirect()->route('reports.index')
                ->with('success', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //delete report
        $report->intervensiKhususes()->detach();
        $report->intervensiNasionalProvinsis()->detach();
        $report->changeChampions()->detach();
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil di hapus');
    }

    public function approve(Request $request, Report $report)
    {
        Auth::user()->cannot('approve', $report) ?  abort(403) : true;

        $report->status = $request->status;
        $report->alasan = $request->alasan;
        $report->save();

        return redirect()->route('reports.index')
            ->with('success', 'Approval berhasil disimpan');
    }

    public function print(Request $request, Report $report)
    {
        return view('reports.print', compact('report'));
    }

    public function getIntervensiNasionalForReport($report)
    {
        //ambil intervensi nasional yang sama dengan tahun dan provinsi report
        $intervensiNasionals = IntervensiNasional::where('tahun', $report->tahun)->get();
        $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
        $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', $report->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->where('status', 2)->get();
        return $intervensiNasionalProvinsis;
    }

    public function getIntervensiKhususForReport($report)
    {
        $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $report->provinsi_id)->where('tahun', $report->tahun)->where('status', 2)->get();
        // $intervensiKhususes = array();
        // $changeChampions = User::where('role_id', 3)->where('provinsi_id', $report->provinsi_id)->get();
        // foreach ($changeChampions as $cc) {
        //     $intervensiKhusus =  $cc->intervensi_khususes()->where('status', 2);
        //     if ($intervensiKhusus != null)
        //         $intervensiKhususes[] = $intervensiKhusus;
        // }
        return $intervensiKhususes;
    }

    public function deleteLampiran($reportId)
    {
        try {
            $report = Report::find($reportId);
            Storage::delete($report->lampiran);
            $report->lampiran = null;
            $report->save();
            return true;
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function downloadLampiran($reportId)
    {

        try {
            $report = Report::find($reportId);
            return Storage::disk('local')->download($report->lampiran);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    //upload laporan
    public function uploadLaporan(Request $request, Report $report)
    {
        $request->validate([
            'laporan' => 'required|file|mimes:pdf|max:6048',
        ]);

        //hapus laporan sebelumnya jika ada
        if ($report->laporan != null) {
            Storage::delete($report->laporan);
        }


        $file = $request->file('laporan');
        $fileName = $report->tahun . '_' . $report->semester . '_' . $report->provinsi->nama . '_' . $report->id;
        $fileExtension = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();
        $fileMimeType = $file->getMimeType();
        $filePath = 'laporan/' . $fileName;
        $file->storeAs('laporan', $fileName);
        $report->laporan = $filePath;

        //ubah status laporan menjadi 4
        $report->status = 4;

        //update last modified
        $report->user_id = Auth::user()->id;

        $report->save();

        return redirect()->route('reports.index', $report)
            ->with('success', 'Laporan berhasil diunggah');
    }

    //unduh laporan
    public function downloadLaporan(Report $report)
    {
        return Storage::disk('local')->download($report->laporan);
    }

    //2021
    public function report2021Show(Report $report)
    {
        return view('reports.2021-show', compact('report'));
    }
}
