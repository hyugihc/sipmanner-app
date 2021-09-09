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
use Throwable;

class ReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();

        //pertama kali masuk buat baru/ambil yang lama
        $reportSm1 = Report::firstOrCreate(
            ['tahun' => date("Y"), 'semester' => '1', 'provinsi_id' => $user->provinsi_id],
            ['status' => '0']
        );

        $reportSm2 = Report::firstOrCreate(
            ['tahun' => date("Y"), 'semester' => '2', 'provinsi_id' => $user->provinsi_id],
            ['status' => '0']
        );

        //pastikan intervensi pada report masih sesuai
        $intervensiNasionals = $this->getIntervensiNasionalReport($user);
        $intervensiKhususes = $this->getIntervensiKhususReport($user);
        if ($reportSm1->status == 0 or $reportSm1->status == 3) {
            $reportSm1->intervensiNasionalProvinsis()->sync($intervensiNasionals);
            $reportSm1->intervensiKhususes()->sync($intervensiKhususes);
        }

        if ($reportSm2->status == 0 or $reportSm2->status == 3) {
            $reportSm2->intervensiNasionalProvinsis()->sync($intervensiNasionals);
            $reportSm2->intervensiKhususes()->sync($intervensiKhususes);
        }

        return view('reports.index', compact('reportSm1', 'reportSm2'));
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
        if (Report::where('provinsi_id', $user->provinsi_id)->where('tahun', $tahun)->where('semester', $semester)->exist()) {
            return redirect()->route('reports.index')
                ->with('warning', "Laporan sudah ada");
        }

        //jika belum ada create laporan
        $report = new Report();
        $report->tahun = $tahun;
        $report->semester = $semester;
        $report->provinsi_id = $user->provinsi_id;

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

        //attach cc jika belum ada
        $changeChampions = User::where('role_id', 3)->where('provinsi_id', $user->provinsi_id)->get();
        if ($report->changeChampions()->count() == 0) {
            $report->changeChampions()->attach($changeChampions, ['status' => 0]);
        } else {
            $report->changeChampions()->sync($changeChampions);
        }

        //pastikan intervensi pada report masih sesuai
        $intervensiNasionals = $this->getIntervensiNasionalReport($user);
        $intervensiKhususes = $this->getIntervensiKhususReport($user);
        if ($report->status == 0 or $report->status == 3) {
            $report->intervensiNasionalProvinsis()->sync($intervensiNasionals);
            $report->intervensiKhususes()->sync($intervensiKhususes);
        }

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
            $report->intervensiKhususes()->detach($ik);
            $report->intervensiKhususes()->attach($ik, ['kendala' => $request->intervensiKhusus_kendala[$ik->id], 'solusi' => $request->intervensiKhusus_solusi[$ik->id]]);
        }

        //perbarui persetujuan jika di cek maupun di uncek
        if ($request->changeChampions[$user->id] != null) {
            //jika di cek
            $report->changeChampions()->syncWithoutDetaching([$user->id => ['status' => 2]]);
        } else {
            //jika di uncek
            $report->changeChampions()->syncWithoutDetaching([$user->id => ['status' => 0]]);
        }

        //pastikan sudah semua tercentang jika ingin submit
        //update CC yang terbaru
        $changeChampions = User::where('role_id', 3)->where('provinsi_id', $user->provinsi_id)->get();
        $report->changeChampions()->sync($changeChampions);
        //pastikan semua cc terbaru tercentang
        if ($request->has("submit")) {
            foreach ($changeChampions as $changeChampion) {
                if ($report->changeChampions()->where('id', $changeChampion->id)->first()->pivot->status != 2) {
                    return redirect()->route('reports.edit', $report)->with('success', 'Laporan berhasil disimpan')
                        ->with('warning', "Laporan belum berhasi disubmit, masih ada CC yang belum setuju");
                }
            }
            $report->status = 1;
        } else {
            $report->status = 0;
        }
        $report->save();

        $message = ($report->status == 0) ? 'Laporan berhasil disimpan menjadi draft' : 'Laporan berhasil disubmit ke Change Leader';
        return redirect()->route('reports.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
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

    public function getIntervensiNasionalReport($user)
    {
        $intervensiNasionals = IntervensiNasional::where('tahun', date("Y"))->get();
        $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
        $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', $user->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();
        return $intervensiNasionalProvinsis;
    }

    public function getIntervensiKhususReport($user)
    {
        $intervensiKhususes = IntervensiKhusus::where('provinsi_id', $user->provinsi_id)->where('tahun', date("Y"))->where('status', 2)->get();
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
}
