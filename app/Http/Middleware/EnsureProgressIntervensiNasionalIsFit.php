<?php

namespace App\Http\Middleware;

use App\IntervensiNasionalProvinsi;
use Closure;

class EnsureProgressIntervensiNasionalIsFit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $progress = $request->route('progress_intervensi_nasional');
        if ($progress != null) {
            $intervensi = $request->route('intervensi_nasional');
            $intervensiProv = IntervensiNasionalProvinsi::where('intervensi_nasional_id', $intervensi->id)->first();
            // dd($intervensiProv);
            //if ($progress->intervensi_nasional_provinsi_id != $intervensiProv->id) {
            //  echo  "intervensi prov id = ".$intervensiProv->id ;
            //return abort(404);
            //}
        }
        return $next($request);
    }
}
