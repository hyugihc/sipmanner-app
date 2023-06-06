<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIntervensiKhususRequest;
use App\IntervensiKhusus;
use Illuminate\Http\Request;
use App\Pia;
use App\Provinsi;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use PhpParser\Node\Stmt\TryCatch;
//define log
use Illuminate\Support\Facades\Log;
//define rb2023
use App\rb2023;

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
        // get rb2023
        $rb2023s = rb2023::all();
        return view('programs.intervensi_khususes.edit-add', compact('rb2023s'));
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
        $user = Auth::user();
        $year = $user->getSetting('tahun');

        $intervensi = IntervensiKhusus::create($request->all());
        $intervensi->provinsi_id = $request->user()->provinsi_id;
        $intervensi->tahun = $year;
        $intervensi->user_id = Auth::user()->id;
        $intervensi->save();
        $intervensi->rb2023s()->attach($request->rb2023s);

        if ($request->has('draft')) {
            $intervensi->status = 0;
            $intervensi->save();
            $message =  'Program Intervensi Khusus Berhasil disimpan  menjadi Draft';
            return redirect()->to(config('app.url') . '/programs')
                ->with('success', $message);
        } else {
            $intervensi->status = 1;
            $intervensi->save();
            //ambil change leader dari provinsi yang sama
            $changeLeader = User::where('role_id', 2)->where('provinsi_id', $intervensi->provinsi_id)->first();
            //kirim notifikasi email ke change leader
            try {
                Notification::send($changeLeader, new \App\Notifications\IntervensiKhususSubmittedToCL($intervensi));
                return  redirect()->to(config('app.url') . '/programs')->with('success', 'Program Intervensi Khusus berhasil di submit ke Change Leader')->with('info', 'email notifikasi telah dikirim ke Change Leader');
            } catch (\Throwable $th) {
                //throw $th;
                return  redirect()->to(config('app.url') . '/programs')->with('success', 'Program Intervensi Khusus berhasil di submit ke Change Leader')->with('warning', 'email notifikasi gagal dikirim ke Change Leader');
            }
        }
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

        $rb2023s = rb2023::all();
        return view('programs.intervensi_khususes.edit-add', compact('intervensiKhusus', 'rb2023s'));
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
        //update rb2023
        $intervensiKhusus->save();
        $intervensiKhusus->rb2023s()->sync($request->rb2023s);

        if ($request->has('draft')) {
            $intervensiKhusus->status = 0;
            $intervensiKhusus->save();
            $message =  'Program Intervensi Khusus Berhasil disimpan  menjadi Draft';
            return  redirect()->to(config('app.url') . '/programs')
                ->with('success', $message);
        } else {
            //submitToCL dengan parameter intervensi khusus
            $intervensiKhusus->status = 1;
            $intervensiKhusus->save();
            //ambil change leader dari provinsi yang sama
            $changeLeader = User::where('role_id', 2)->where('provinsi_id', $intervensiKhusus->provinsi_id)->first();
            //kirim notifikasi email ke change leader
            try {
                Notification::send($changeLeader, new \App\Notifications\IntervensiKhususSubmittedToCL($intervensiKhusus));
                return  redirect()->to(config('app.url') . '/programs')->with('success', 'Program Intervensi Khusus berhasil di submit ke Change Leader')->with('info', 'email notifikasi telah dikirim ke Change Leader');
            } catch (\Throwable $th) {
                //catatkan error handling tentang email di file log menggunakan monolog
                Log::error("Email gagal dikirim ke: " . $changeLeader->name . " dari " . Auth::user()->name . " " . $th->getMessage());
                return  redirect()->to(config('app.url') . '/programs')->with('success', 'Program Intervensi Khusus berhasil di submit ke Change Leader')->with('warning', 'email notifikasi gagal dikirim ke Change Leader');
            }
        }
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
        $intervensiKhusus->rb2023s()->detach();
        $intervensiKhusus->delete();
        return redirect()->route('programs.index')
            ->with('success', 'Program Intervensi Khusus berhasil dihapus');
    }

    public function approve(Request $request, IntervensiKhusus $intervensiKhusus)
    {

        $intervensiKhusus->status = $request->status;
        $intervensiKhusus->alasan = $request->alasan;
        $intervensiKhusus->save();

        $message = ($intervensiKhusus->status == 2) ? 'Program Intervensi Khusus Berhasil disetujui' : 'Program Intervensi Khusus berhasil untuk tidak disetujui';

        return redirect()->route('programs.index')
            ->with('success', $message);
    }
}
