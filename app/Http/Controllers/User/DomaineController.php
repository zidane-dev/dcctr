<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Dpci;
use App\Models\Dr;
use Exception;
use Illuminate\Support\Facades\Auth;

class DomaineController extends Controller
{
    public function get_domaines($choice = null){
        if(Auth::user()->hasPermissionTo('view-select')){
            if($choice != null){
                $dom = Dpci::select('id', 'type as t')->where('id', $choice)->first();
                if($dom->t == "DR"){
                    $domaine = $this->get_domaineGroup($choice); 
                }
                else{
                    $domaine = [$choice];
                }
            } else{
                $domaine = null;
            }
        }
        elseif(Auth::user()->hasPermissionTo('view-region')) {
            $domaine = $this->get_domaineGroup(Auth::user()->domaine->id); 
        } 
        elseif(Auth::user()->hasPermissionTo('view-province')) {
            $domaine = [Auth::user()->domaine->id];
        }
        else{
            return null;
        }
        return $domaine; //array
    }

    public function get_domaineGroup($domaine_id){ 
        $domaine = Dpci::where('id' , $domaine_id)->first();
        $region =  Dr::where('id', $domaine->dr_id)->first();
        $domaine_group = [];
        foreach($region->provinces as $province){
            array_push($domaine_group, $province->id);
        }
        if($domaine_group != null)
            return $domaine_group;
        else
            return 'Nothing found';
    }

}
