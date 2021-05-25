<?php

namespace App\Http\Controllers;

use App\Can;
use App\Policies\CanPolicy;
use App\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        Auth::user()->cannot('viewAny', Can::class) ?  abort(403) : true;

        if (Auth::user()->role_id == 1 or Auth::user()->role_id == 5) {
            $cans = Can::paginate(5);
        } else {
            $cans = Can::where('provinsi_id', Auth::user()->provinsi_id)->paginate(5);
        }

        return view('cans.index', compact('cans'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        Auth::user()->cannot('create', Can::class) ?  abort(403) : true;

        $provinsis = Provinsi::all();
        return view('cans.create', compact('provinsis'));
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
        Auth::user()->cannot('create', Can::class) ?  abort(403) : true;

        $request->validate([
            'nomor_sk' => 'required',
            'tanggal_sk' => 'required',
            'tanggal_sk' => 'required',
            'perihal_sk' => 'required',
            'file_sk' => 'required',
        ]);

        $can = new Can;
        $can->nomor_sk = $request->nomor_sk;
        $can->tanggal_sk = $request->tanggal_sk;
        $can->perihal_sk = $request->perihal_sk;
        $can->approval = $request->approval;
        $can->alasan = $request->alasan;

        if (Auth::user()->role_id == 1) {
            $can->provinsi_id = $request->provinsi_id;
        } else {
            $can->provinsi_id = Auth::user()->provinsi_id;
        }



        $can->file_sk = Storage::putFile('public/cans', $request->file_sk);

        // $can->file_sk = Storage::putFileAs('cans', $request->file('file_sk'), $request->user()->nomor_sk);



        $can->save();

        $can->users()->attach($request->users);

        // Can::create($request->all());

        return redirect()->route('cans.index')
            ->with('success', 'Can created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Can  $can
     * @return \Illuminate\Http\Response
     */
    public function show(Can $can)
    {
        //

        Auth::user()->cannot('view', $can) ?  abort(403) : true;

        return view('cans.show', compact('can'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Can  $can
     * @return \Illuminate\Http\Response
     */
    public function edit(Can $can)
    {
        //
        Auth::user()->cannot('update', $can) ?  abort(403) : true;


        return view('cans.edit', compact('can'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Can  $can
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Can $can)
    {
        // //

        Auth::user()->cannot('update', $can) ?  abort(403) : true;

        $request->validate([
            'nomor_sk' => 'required',
            'tanggal_sk' => 'required',
            'tanggal_sk' => 'required',
            'perihal_sk' => 'required',
            'file_sk' => 'required',
        ]);


        $can->update($request->all());

        return redirect()->route('cans.index')
            ->with('success', 'Can updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Can  $can
     * @return \Illuminate\Http\Response
     */
    public function destroy(Can $can)
    {
        //
        Auth::user()->cannot('delete', $can) ?  abort(403) : true;

        $can->delete();

        return redirect()->route('cans.index')
            ->with('success', 'Can deleted successfully');
    }

    public function downloadFileSk(Can $can)
    {

        try {
            //code...

            return Storage::disk('local')->download($can->file_sk);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
