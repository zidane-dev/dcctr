<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Throwable;

class TestController extends Controller
{
    public function index(){
        $rcs = Role::findByName('rcs');
        $acs = Role::findByName('acs');
        $dcs = Role::findByName('dcs');
        // $acs->g


        $permissions = Permission::select('id', 'name')->cursor();
        $roles = Role::select('id', 'name')->cursor();

        return view('permissions.index', compact('permissions', 'roles'));
    }

    public function role_permissions($id){
        $role = Role::findById($id);
        return $this->model_permissions($role);
    }
    public function user_permissions($id){
        $user = User::find($id);
        return $this->model_permissions($user);
    }

    public function assign_to_role($id){
        $role = Role::findById($id);
        $permissions = $this->model_permissions($role);
    }
    public function assign_to_user($id){
        $user = User::find($id);
        $permissions = $this->model_permissions($user);
    }
    public function model_permissions($model){
        dd($model->getAllPermissions()->first()->id);
        return $model->getAllPermissions();
    }

    public function update_permissions($model, $permissions){
        try{
            $model->syncPermissions($permissions); //permissions must be array
            Session::flash('success', __('permissions.success'));
        }catch(Throwable $t){
            Session::flash('error', __('permissions.error'.' '.$t));
        }
        return redirect()->route('rights');
    }

    public function session(Request $request){
        dd($request->session()->all());
    }
    public function requete(Request $request){
        dd($request);
    }
}