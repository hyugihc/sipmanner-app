<?php

namespace App\Http\Controllers;

use App\Can;
use Illuminate\Http\Request;
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
        $cans = Can::latest()->paginate(5);

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
        return view('cans.create');
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
        //   $can->file_sk = $request->file_sk;
        $can->approval = $request->approval;
        $can->kode_org = $request->kode_org;
        $can->alasan = $request->alasan;

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
