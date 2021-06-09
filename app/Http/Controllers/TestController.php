<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestController extends Controller
{
    public function index(){
        
        $permissions = Permission::select('id', 'name')->cursor();
        $roles = Role::select('id', 'name')->cursor();

        return view('permissions.index', compact('permissions', 'roles'));


    }
}