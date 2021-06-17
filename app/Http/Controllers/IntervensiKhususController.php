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

        Auth::user()->cannot('viewAny', IntervensiKhusus::class) ?  abort(403) : true;

        $intervensiKhususes = (Auth::user()->role_id == 1) ?
            IntervensiKhusus::paginate(5) : IntervensiKhusus::where('provinsi_id', Auth::user()->provinsi_id)->paginate(5);
        return view('programs.intervensi_khususes.index', compact('intervensiKhususes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        Auth::user()->cannot('create', IntervensiKhusus::class) ?  abort(403) : true;

        $pias = Pia::all();
        $provinsis = Provinsi::all();
        return view('programs.intervensi_khususes.create', compact('pias', 'provinsis'));
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
        Auth::user()->cannot('create', IntervensiKhusus::class) ?  abort(403) : true;

        $request->validate([
            'nama' => 'required|min:3|max:50',
            'uraian_kegiatan' => 'required|max:500',
            'volume' => 'required',
            'output' => 'required',
            'outcome' => 'required',
            'pias' => 'required',
        ]);


        $intervensi = IntervensiKhusus::create($request->all());
        $intervensi->provinsi_id = ($request->user()->role_id == 1)  ? $request->provinsi_id :
            $request->user()->provinsi_id;
        $intervensi->tahun = date("Y");
        $intervensi->user_id = Auth::user()->id;
        $intervensi->pias()->attach($request->pias);
        $intervensi->status  = ($request->has('draft')) ? 0 : 1;
        $intervensi->save();

        $message = ($intervensi->status == 0) ? 'Program Intervensi Khusus drafted successfully.' : 'Program Intervensi Khusus submitted successfully.';
        return redirect()->route('programs.index')
            ->with('success', $message);
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
        Auth::user()->cannot('view', $intervensiKhusus) ?  abort(403) : true;

        return view('programs.intervensi_khususes.show', compact('intervensiKhusus'));
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
        Auth::user()->cannot('update', $intervensiKhusus) ?  abort(403) : true;


        $idPia = $intervensiKhusus->pias->pluck('id');

        $pias = Pia::all();
        $provinsis = Provinsi::all();
        return view('programs.intervensi_khususes.edit', compact('intervensiKhusus', 'pias', 'provinsis', 'idPia'));
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
        Auth::user()->cannot('update', $intervensiKhusus) ?  abort(403) : true;

        $request->validate([
            'nama' => 'required|min:3|max:50',
            'uraian_kegiatan' => 'required|max:500',
            'volume' => 'required',
            'output' => 'required',
            'outcome' => 'required',
            'pias' => 'required',
        ]);

        $intervensiKhusus->update($request->all());
        $intervensiKhusus->provinsi_id = ($request->user()->role_id == 1)  ? $request->provinsi_id :
            $request->user()->provinsi_id;
        $intervensiKhusus->status  = ($request->has('draft')) ? 0 : 1;
        $intervensiKhusus->pias()->sync($request->pias);
        $intervensiKhusus->save();



        $message = ($intervensiKhusus->status == 0) ? 'Program Intervensi Khusus drafted successfully.' : 'Program Intervensi Khusus submitted successfully.';
        return redirect()->route('programs.index')
            ->with('success', $message);
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
        Auth::user()->cannot('delete', $intervensiKhusus) ?  abort(403) : true;

        $intervensiKhusus->delete();
        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Khusus deleted successfully');
    }

    public function approve(Request $request, IntervensiKhusus $intervensiKhusus)
    {
        Auth::user()->cannot('approve', $intervensiKhusus) ?  abort(403) : true;
        $intervensiKhusus->status = $request->status;
        $intervensiKhusus->alasan = $request->alasan;
        $intervensiKhusus->save();

        return redirect()->route('programs.index')
            ->with('success', 'Approval is successfully assigned');
    }
}
