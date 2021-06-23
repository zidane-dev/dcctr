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
        $rhsds = (new RhValidationController)->getBadgeRefresh($request);
        $bdgs = (new BdgValidationController)->getBadgeRefresh($request);
        $atts = (new ADgValidationController)->getBadgeRefresh($request);
        $indics = 99;
        // $rhsds = (new RhsdController)->get_count($userRole, 1);
        $request->session()->put('rh_count', $rhsds);
        $request->session()->put('bdg_count', $bdgs);
        $request->session()->put('attproc_count', $atts);
        $request->session()->put('indic_count', $indics);
    }

    private function get_count($rows){
        return $rows->count();
    }
    
}
