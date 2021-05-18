<?php

namespace App\Http\Controllers;

use App\Can;
use Illuminate\Http\Request;

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
  
        return view('cans.index',compact('cans'))
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
        
        // $can= new Can;
        // $can->name = $request->name;
  
        Can::create($request->all());
   
        return redirect()->route('cans.index')
                        ->with('success','Can created successfully.');
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
        return view('cans.show',compact('can'));
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
        return view('cans.edit',compact('can'));
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
                        ->with('success','Can updated successfully');
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
                        ->with('success','Can deleted successfully');
    }

 


}
