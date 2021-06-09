<?php

namespace App\Http\Controllers;

use App\Models\Dpci;
use App\Models\Dr;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AxeHelperController extends Controller
{
    public function getUserRole(){  
        $uss = User::where('email',Auth::user()->email)->where('id',Auth::id())->first();
        $userRole = $uss->roles->pluck('name')->first();
        return $userRole;
    }
    public function get_domaineGroup($dom = null){
        if($dom == null)
            $domaine_id = Auth::user()->domaine->id;
        else
            $domaine_id = $dom;
        $domaine = Dpci::where('id' ,'=', $domaine_id)->first();
        $region =  Dr::where('id', '=', $domaine->dr_id)->first();
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
