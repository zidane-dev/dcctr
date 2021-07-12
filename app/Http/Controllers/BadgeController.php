<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Validation\ADgValidationController;
use App\Http\Controllers\Validation\BdgValidationController;
use App\Http\Controllers\Validation\RhValidationController;
use App\Models\Rhsd;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    

    public function refresh_badges($request){
        $indics = 0;
        $request->session()->put('rh_count'     , (new RhValidationController)->getBadgeRefresh($request) );
        $request->session()->put('bdg_count'    , (new BdgValidationController)->getBadgeRefresh($request));
        $request->session()->put('attproc_count', (new ADgValidationController)->getBadgeRefresh($request));
        $request->session()->put('indic_count'  , $indics);
    }


    
}
