<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function put_domaine_in(Request $request, $domaines){
        $request->session()->put('domaine_in', $domaines);
    }
    public function get_domaine_in(Request $request){
        if ($request->session()->has('domaine_in'))
            return $request->session()->get('domaine_in');
        else
            return null;
    }
    public function erase_domaine_in(Request $request){
        $request->session()->forget('domaine_in');
    }
}
