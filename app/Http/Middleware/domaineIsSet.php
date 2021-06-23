<?php

namespace App\Http\Middleware;

use App\Http\Controllers\User\DomaineController;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class domaineIsSet
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
            if(!$request->has('domaine_in'))
                return redirect()->route('preindex');
        }
        else{
            if(!$request->session()->has('domaine_in')){
                $domaines = (new DomaineController)->get_domaines($request->session()->get('domaine_id'));
                $request->session()->put('domaine_in', $domaines);
            }
        }
        return $next($request);
    }
}
