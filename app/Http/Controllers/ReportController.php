<?php

namespace App\Http\Controllers;

use App\IntervensiKhusus;
use App\IntervensiNasional;
use App\IntervensiNasionalProvinsi;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    private $bab_i = '';
    private $bab_ii = '';
    private $bab_iii = '';
    private $bab_iv = '';
    private $bab_v = '';
    private $bab_vi = '';
    private $bab_vii = '';
    private $bab_viii = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reportSm1 = Report::firstOrCreate(
            ['tahun' => date("Y"), 'semester' => '1', 'provinsi_id' => Auth::user()->provinsi_id],
            ['status' => '0',  'bab_i' => $this->bab_i, 'bab_ii' => $this->bab_ii, 'bab_iii' => $this->bab_iii, 'bab_iv' => $this->bab_iv, 'bab_v' => $this->bab_v, 'bab_vi' => $this->bab_vi, 'bab_vii' => $this->bab_vii, 'bab_viii' => $this->bab_viii]
        );
        $reportSm2 = Report::firstOrCreate(
            ['tahun' => date("Y"), 'semester' => '2', 'provinsi_id' => Auth::user()->provinsi_id],
            ['status' => '0',  'bab_i' => $this->bab_i, 'bab_ii' => $this->bab_ii, 'bab_iii' => $this->bab_iii, 'bab_iv' => $this->bab_iv, 'bab_v' => $this->bab_v, 'bab_vi' => $this->bab_vi, 'bab_vii' => $this->bab_vii, 'bab_viii' => $this->bab_viii]
        );

        return view('reports.index', compact('reportSm1',  'reportSm2'));
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
        $intervensiNasionals = IntervensiNasional::where('tahun', date("Y"))->get();
        $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
        $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', Auth::user()->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();

        $intervensiKhususes = IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun', date("Y"))->where('status', 2)->get();

        return view('reports.show', compact('report', 'intervensiNasionalProvinsis', 'intervensiKhususes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
        $intervensiNasionals = IntervensiNasional::where('tahun', date("Y"))->get();
        $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
        $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', Auth::user()->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();

        $intervensiKhususes = IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun', date("Y"))->where('status', 2)->get();


        return view('reports.edit', compact('report', 'intervensiNasionalProvinsis', 'intervensiKhususes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
        $report->update($request->all());
        $report->user_id = $request->user()->id;
        $report->status  = ($request->has('draft')) ? 0 : 1;
        $report->save();

        $message = ($report->status == 0) ? 'Data berhasil disimpan menjadi draft' : 'Data berhasil disubmit ke Change Leader';
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

        $intervensiNasionals = IntervensiNasional::where('tahun', date("Y"))->get();
        $intervensiNasionalKeys = $intervensiNasionals->modelKeys();
        $intervensiNasionalProvinsis = IntervensiNasionalProvinsi::where('provinsi_id', Auth::user()->provinsi_id)->whereIn('intervensi_nasional_id', $intervensiNasionalKeys)->get();

        $intervensiKhususes = IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->where('tahun', date("Y"))->where('status', 2)->get();

        return view('reports.print', compact('report', 'intervensiNasionalProvinsis', 'intervensiKhususes'));
    }
}
