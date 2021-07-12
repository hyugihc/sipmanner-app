<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIntervensiKhususRequest;
use App\IntervensiKhusus;
use Illuminate\Http\Request;
use App\Pia;
use App\Provinsi;
use Illuminate\Support\Facades\Auth;

class IntervensiKhususController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(IntervensiKhusus::class, 'intervensi_khusus');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $pias = Pia::all();
        return view('programs.intervensi_khususes.edit-add', compact('pias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIntervensiKhususRequest $request)
    {
        //
        $intervensi = IntervensiKhusus::create($request->all());
        $intervensi->provinsi_id = $request->user()->provinsi_id;
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

        $idPia = $intervensiKhusus->pias->pluck('id');
        $pias = Pia::all();
        return view('programs.intervensi_khususes.edit-add', compact('intervensiKhusus', 'pias', 'idPia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IntervensiKhusus  $intervensiKhusus
     * @return \Illuminate\Http\Response
     */
    public function update(StoreIntervensiKhususRequest $request, IntervensiKhusus $intervensiKhusus)
    {
        //

        $intervensiKhusus->update($request->all());
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
        $intervensiKhusus->pias()->detach();
        $intervensiKhusus->delete();
        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Khusus deleted successfully');
    }

    public function approve(Request $request, IntervensiKhusus $intervensiKhusus)
    {

        $intervensiKhusus->status = $request->status;
        $intervensiKhusus->alasan = $request->alasan;
        $intervensiKhusus->save();

        return redirect()->route('programs.index')
            ->with('success', 'Approval is successfully assigned');
    }
}
