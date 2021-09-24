<?php

namespace App\Http\Controllers;

use App\Can;
use App\Http\Requests\StoreCanRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $year = $user->getSetting('tahun');

        // $cans = ($user->isAdmin() or $user->isTopLeader()) ?
        //     Can::where('tahun_sk', $year)->orderBy('status_sk')->paginate(5) :
        //     Can::where('tahun_sk', $year)->orderBy('status_sk')->where('provinsi_id', $user->provinsi_id)->paginate(5);

        $cans = null;
        if ($user->isAdmin()) {
            $cans = Can::where('tahun_sk', $year)->orderBy('status_sk')->paginate(5);
        } elseif (($user->isChangeChampion() or $user->isChangeLeader()) and $user->provinsi->isPusat()) {
            $cans =  Can::where('tahun_sk', $year)->where('status_sk', 2)->orderBy('tahun_sk')->where('pusat', 1)->paginate(5);
        } elseif ($user->isChangeChampion()) {
            $cans =  Can::where('tahun_sk', $year)->orderBy('status_sk')->where('provinsi_id', $user->provinsi_id)->paginate(5);
        } elseif ($user->isChangeLeader()) {
            $canStatus = [1, 2, 4];
            $cans =  Can::where('tahun_sk', $year)->whereIn('status_sk', $canStatus)->orderBy('status_sk')->where('provinsi_id', $user->provinsi_id)->paginate(5);
        }

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


        if ($request->has('submit')) {
            $request->validate([
                'nomor_sk'  => 'required|min:3|max:255|unique:cans',
                'file_sk' => 'required|mimes:pdf|max:3000'
            ]);
        }

        $user = $request->user();
        $changeLeaders = User::where('role_id', 2)->where('provinsi_id', $user->provinsi_id)->get();
        $changeChampions = User::where('role_id', 3)->where('provinsi_id', $user->provinsi_id)->get();

        //create can
        $can = Can::create($request->all());

        $year = $user->getSetting('tahun');

        $can->tahun_sk = $year;
        $can->user_id = $user->id;
        if ($user->isAdmin()) {
            $can->pusat = 1;
        } else {
            $can->provinsi_id = $user->provinsi_id;
        }
        $can->status_sk  = ($request->has('draft')) ? 0 : 1;
        $can->save();


        if ($request->has('file_sk')) {
            $can->file_sk =   $request->file('file_sk')->storeAs('cans', $can->getNameFileSK());
        }
        if ($request->has('change_agents'))
            $can->attachChangeAgents($request->change_agents);
        $can->attachChangeChampions($changeChampions);
        $can->attachChangeLeaders($changeLeaders);
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
        //
        if ($request->has('submit')) {
            $request->validate([
                'nomor_sk'  => 'required|min:3|max:255|unique:cans,nomor_sk,' . $can->id
            ]);
            if ($can->file_sk == null) {
                $request->validate([
                    'file_sk' => 'required|mimes:pdf|max:3000'
                ]);
            }
        }

        $can->update($request->all());
        $can->status_sk  = ($request->has('draft')) ? 0 : 1;

        if ($request->has('file_sk')) {
            $request->validate([
                'file_sk' => 'required|mimes:pdf|max:3000'
            ]);
            if ($can->file_sk != null) {
                Storage::delete($can->file_sk);
            }
            $can->file_sk = $request->file('file_sk')->storeAs('cans', $can->getNameFileSK());
        }
        if ($request->has('change_agents'))
            $can->syncChangeAgents($request->change_agents);
        $can->save();

        $message = ($can->status_sk == 0) ? 'Data berhasil disimpan menjadi draft' : 'Data berhasil disubmit ke Change Leader';
        return redirect()->route('cans.index')
            ->with('success', $message);
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

    public function recap()
    {
        return view('cans.recap');
    }
}
