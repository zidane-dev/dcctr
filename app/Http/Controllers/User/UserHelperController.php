<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserHelperController extends Controller
{
    public function getUserRole(){  
        $uss = User::where('id',Auth::id())->first();
        $userRole = $uss->roles->pluck('name')->first();
        return $userRole;
    }
    public function getUserScope(){
        if(Auth::user()->hasPermissionTo('view-province')){
            return 'Vue Provinciale';
        }elseif(Auth::user()->hasPermissionTo('view-region')){
            return 'Vue Regionale';
        }elseif(Auth::user()->hasPermissionTo('view-select')){
            return 'Vue Globale (filtrable)';
        }else{
            return 0;
        }
    }
}