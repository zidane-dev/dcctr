<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHelperController extends Controller
{
    public function getUserRole(){  
        $uss = User::where('id',Auth::id())->first();
        $userRole = $uss->roles->pluck('name')->first();
        return $userRole;
    }
}
