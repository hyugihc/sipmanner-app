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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();
        $reportSm1 = Report::firstOrCreate(
            ['tahun' => date("Y"), 'semester' => '1', 'provinsi_id' => $user->provinsi_id],
            ['status' => '0']
        );
        $reportSm2 = Report::firstOrCreate(
            ['tahun' => date("Y"), 'semester' => '2', 'provinsi_id' => $user->provinsi_id],
            ['status' => '0']
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
