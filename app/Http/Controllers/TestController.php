<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
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

    public function assign_to_role($role, $req_permissions){
        $role_perms = $this->model_permissions($role);
        $diff1 = array_diff($role_perms, $req_permissions); // gives
        $diff2 = array_diff($req_permissions, $role_perms); // gives
        if($diff1!=$diff2){
            $role->syncPermissions($req_permissions);
            Session::flash('success', 'GG'); //TRANS THIS
            return 1;
        }elseif($diff1 == $diff2){
            Session::flash('success', 'RAS'); //TRANS THIS
            return 1;
        }
        else{
            throw new Exception('PAS GG');
        }
    }
    public function assign_to_user($id){
        $user = User::find($id);
        $permissions = $this->model_permissions($user);
    }
    public function model_permissions($model){
        return $model->getAllPermissions()->pluck('name')->all();
    }

    public function update_permissions(Request $request){
        try{
            $role_name = $request->input('role_name');
            $role = Role::findByName($role_name);
            $req_permissions = $request->input('permission');
            $this->assign_to_role($role, $req_permissions);
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