<?php

namespace App\Http\Middleware;

use Closure;

class EnsureProgressIntervensiKhususIsFit
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
        $progress = $request->route('progress_intervensi_khusus');
        if ($progress != null) {
            $intervensi = $request->route('intervensi_khusus');
            if ($progress->intervensi_khusus_id != $intervensi->id) {
                return abort(404);
            }
        }
        return $next($request);
    }
}
