<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class domaineIsUnset
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
        if(Auth::user()->hasAnyPermission(['dc', 'administrate'])){
            if($request->session()->has('domaine_in'))
                $request->session()->forget('domaine_in');
        }
        return $next($request);
    }
}
