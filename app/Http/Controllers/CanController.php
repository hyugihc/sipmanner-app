<?php

namespace App\Http\Controllers;

use App\Can;
use App\Http\Requests\StoreCanRequest;
use App\Provinsi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CanController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Can::class, 'can');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cans = (Auth::user()->role_id == 1 or Auth::user()->role_id == 5) ?
            Can::orderBy('status_sk')->paginate(5) :
            Can::orderBy('status_sk')->where('provinsi_id', Auth::user()->provinsi_id)->paginate(5);
        return view('cans.index', compact('cans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $changeLeaders = User::where('role_id', 2)->where('provinsi_id', Auth::user()->provinsi_id)->get();
        $changeChampions = User::where('role_id', 3)->where('provinsi_id', Auth::user()->provinsi_id)->get();

        return view('cans.create', compact('changeLeaders', 'changeChampions'));
    }



    /**
     * Store and submit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCanRequest $request)
    {
        //create can
        $can = Can::create($request->all());
        $can->tahun_sk = date("Y");
        $can->user_id = $request->user()->id;
        $can->provinsi_id = $request->user()->provinsi_id;
        $can->status_sk  = ($request->has('draft')) ? 0 : 1;
        $can->file_sk = $request->file('file_sk')->storeAs(
            'cans',
            'sk_' . $request->tahun_sk . '_' .
                $request->user()->provinsi->kode_provinsi . '_' . $can->id . '.pdf'
        );

        //can_user
        $changeLeaders = User::where('role_id', 2)->where('provinsi_id', Auth::user()->provinsi_id)->get();
        $changeChampions = User::where('role_id', 3)->where('provinsi_id', Auth::user()->provinsi_id)->get();
        Can::attachChangeAgents($can, $request->change_agents);
        Can::attachChangeChampions($can, $changeChampions);
        Can::attachChangeLeaders($can, $changeLeaders);
        $can->save();

        $message = ($can->status_sk == 0) ? 'Data berhasil disimpan menjadi draft' : 'Data berhasil disubmit ke Change Leader';
        return redirect()->route('cans.index')
            ->with('success', $message);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Can  $can
     * @return \Illuminate\Http\Response
     */
    public function show(Can $can)
    {
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
        return view('cans.edit', compact('can'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Can  $can
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCanRequest $request, Can $can)
    {

        //update can
        $can->update($request->all());
        $can->status_sk  = ($request->has('draft')) ? 0 : 1;
        if ($request->file_sk != null) {
            Storage::delete($can->file_sk);
            $can->file_sk = $request->file('file_sk')->storeAs(
                'cans',
                'sk_' . $can->tahun_sk . '_' .
                    $request->user()->provinsi->kode_provinsi . '_' . $can->id . '.pdf'
            );
        }

        //attach_can
        $can->changeAgents()->detach();
        Can::attachChangeAgents($can, $request->change_agents);
        $can->save();

        $message = ($can->status_sk == 0) ? 'Data berhasil disimpan menjadi draft' : 'Data berhasil disubmit ke Change Leader';
        return redirect()->route('cans.index')
            ->with('success', $message);
    }

    private function mapChangeAgents($change_agents)
    {
        return collect($change_agents)->map(function ($i) {
            return ['amount' => $i];
        });
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Can  $can
     * @return \Illuminate\Http\Response
     */
    public function destroy(Can $can)
    {
        $can->changeChampions()->detach();
        $can->changeLeaders()->detach();
        $can->changeAgents()->detach();
        $can->delete();

        return redirect()->route('cans.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function downloadFileSk(Can $can)
    {
        try {
            return Storage::disk('local')->download($can->file_sk);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function approve(Request $request, Can $can)
    {
        Auth::user()->cannot('approve', $can) ?  abort(403) : true;

        $oldCan = Can::where('provinsi_id', $can->provinsi_id)->where('status_sk', '2')->first();
        if ($oldCan != null) {
            $oldCan->status_sk = 4;
            $oldCan->save();
        }

        $can->status_sk = $request->status_sk;
        $can->alasan = $request->alasan;
        $can->save();

        return redirect()->route('cans.index')
            ->with('success', 'Approval berhasil disimpan');
    }
}
