<?php

namespace App\Http\Controllers;

use App\Can;
use App\Provinsi;
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
        $provinsis = Provinsi::all();
        $change_leaders = User::where('role_id', 2)->where('provinsi_id', Auth::user()->provinsi_id)->get();
        $change_champions = User::where('role_id', 3)->where('provinsi_id', Auth::user()->provinsi_id)->get();
        return view('cans.create', compact('provinsis', 'change_leaders', 'change_champions'));
    }

    /**
     * Store and submit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_sk' => 'required|min:4|max:4',
            'nomor_sk' => 'required|unique:cans|min:3|max:255',
            'tanggal_sk' => 'required',
            'perihal_sk' => 'required',
            'file_sk' => 'required|mimes:pdf|max:3000',
        ]);


        $can = Can::create($request->all());
        $can->file_sk = $request->file('file_sk')->storeAs(
            'cans',
            'sk_' . $request->tahun_sk . '_' .
                $request->user()->provinsi_id . '_' . $can->id . '.pdf'
        );
        Auth::user()->role_id == 1 ?
            $can->provinsi_id = $request->provinsi_id :
            $can->provinsi_id = Auth::user()->provinsi_id;
        $can->user_id= $request->user()->id;    
        $can->status_sk  = ($request->has('draft')) ? 0 : 1;
        $can->save();




        foreach ($request->change_agents as $change_agent) {
            $can->change_agents()->attach($change_agent, ['role_id' => 4]);
        }


        $change_leaders = User::where('role_id', 2)->where('provinsi_id', Auth::user()->provinsi_id)->get();
        $change_champions = User::where('role_id', 3)->where('provinsi_id', Auth::user()->provinsi_id)->get();

        foreach ($change_leaders as $cl) {
            $can->change_leaders()->attach($cl, ['role_id' => 2]);
        }
        foreach ($change_champions as $cc) {
            $can->change_champions()->attach($cc, ['role_id' => 3]);
        }

        //  $can->users()->syncWithPivotValues($request->users, ['role_id' => 4]);


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
    public function update(Request $request, Can $can)
    {
        $request->validate([
            'tahun_sk' => 'required|min:4|max:4',
            'nomor_sk' => 'required|min:3|max:255',
            'tanggal_sk' => 'required',
            'perihal_sk' => 'required',
            'file_sk' => 'nullable|max:3000|mimes:pdf',
        ]);


        $can->update($request->all());

        if ($request->file_sk != null) {
            Storage::delete($can->file_sk);
            $can->file_sk = $request->file('file_sk')->storeAs(
                'cans',
                'sk_' . $can->tahun_sk . '_' .
                    $request->user()->provinsi_id . '_' . $can->id . '.pdf'
            );
        }


        $can->provinsi_id = (Auth::user()->role_id == 1) ?
            $request->provinsi_id :
            Auth::user()->provinsi_id;
        $can->status_sk  = ($request->has('draft')) ? 0 : 1;


        $can->change_agents()->detach();
        if ($request->change_agents != null) {
            foreach ($request->change_agents as $change_agent) {
                $can->change_agents()->attach($change_agent, ['role_id' => 4]);
            }
        }

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
        $can->change_champions()->detach();
        $can->change_leaders()->detach();
        $can->change_agents()->detach();

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

        if ($request->status_sk == 3) {
            $oldCan = Can::where('provinsi_id', $can->provinsi_id)->where('status_sk', '2')->first();
            if ($oldCan != null) {
                $oldCan->status_sk = 4;
                $oldCan->save();
            }
        }

        $can->status_sk = $request->status_sk;
        $can->alasan = $request->alasan;
        $can->save();

        return redirect()->route('cans.index')
            ->with('success', 'Approval berhasil disimpan');
    }
}
