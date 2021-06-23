<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\User\DomaineController;
use App\Http\Controllers\User\UserHelperController;
use App\Http\Controllers\Validation\UserValidationController;
use App\Models\Dpci;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Throwable;

class AxeValidationController extends Controller
{
    private string $table;

    public function __construct($table)
    {
        // $route_name = 1;
        // // $name = explode('.',$route_name);
        // dd($route_name);
        $this->table = $table;
        $this->userValidationHelper = (new UserValidationController);
    } 

    public function setTableAttribute($value){
        $this->table = $value;
    }
    public function getTable(){
        return $this->table;
    }

    public function get_query(){ // query back with ETAT, REJET, and ID_DOMAINE.
        if($this->table == null)
            throw new Exception("Table is not set correctly.", 1);
        $helper = $this->userValidationHelper;
        $userRole = (new UserHelperController)->getUserRole();
        $etats = $helper->get_supposed_states($userRole);
        $rejets = $helper->get_reject_states($userRole);

        $query = DB::table($this->table)
                                    ->where('deleted_at', NULL)
                                    ->whereIn('ETAT', $etats)
                                    ->whereIn('REJET', $rejets);
        
        $domaines = (new DomaineController)->get_domaine();
        if($domaines != null)
            $query = $query->whereIn('id_domaine', $domaines);
                
        return $query;
    }
    public function get_states_overview(){ // state count view
        $query = $this->get_query();

        $helper = $this->userValidationHelper;
                        
        // dd(Auth::user()->hasPermissionTo('ac'));
        $state_o =      $query->where('etat', '=', $helper->get_supposed_states('pf'))->whereIn('REJET', [0,1])->count(); 
        $state_one =    $query->where('etat', '=', $helper->get_supposed_states('cs'))->count();
        $state_two =    $query->where('etat', '=', $helper->get_supposed_states('d-p'))->count();
        $state_three =  $query->where('etat', '=', $helper->get_supposed_states('d-r'))->count();
        

        if(Auth::user()->hasPermissionTo('view-province')){
            if(Auth::user()->hasPermissionTo('ac'))
                $state_one =    $query->where('etat', '=', $helper->get_supposed_states('acs'))->count();

            $rows_count = [ 'states' =>
                                        ['state_o'      => $state_o,
                                        'state_one'     => $state_one,
                                        'state_two'     => $state_two ]];
        } elseif(Auth::user()->hasPermissionTo('view-region')){
            $rows_count = [ 'states' =>
                                        ['state_o'      => $state_o,
                                        'state_one'     => $state_one,
                                        'state_two'     => $state_two,
                                        'state_three'   => $state_three]];
        } elseif(Auth::user()->hasPermissionTo('view-select')){
            $state_four =   $query->where('etat', '=', $helper->get_supposed_states('dcs'))->count();
            $state_five =   $query->where('etat', '=', $helper->get_supposed_states('dcd'))->count();
            $state_six =    $query->where('ETAT', '=', $helper->get_supposed_states('dd'))->count();

            $rows_count = [ 'states' =>
                                        ['state_o'      => $state_o,
                                        'state_one'     => $state_one,
                                        'state_two'     => $state_two,
                                        'state_three'   => $state_three,
                                        'state_four'    => $state_four,
                                        'state_five'    => $state_five,
                                        'state_six'     => $state_six]];
        }
        $rows_response = (object) $rows_count;
        return $rows_response; 
    }

    public function get_goals($rows_count = null){
        $query = $this->get_query();
        $rows =         $query->count();                                             //commentable i want the states
        $goal_done =    $query->where('etat', 6)->where('ECART', '>=', 0)->count(); //commentable i want the states here (index validation)
        if($rows_count != null){
            $rows_count->rows = $rows;
            $rows_count->goals = $goal_done;
            return $rows_count;
        }else{
             return  (object) ['rows' => $rows,
                        'goals' => $goal_done];
        }  
    }
    private function get_valid_rows($selected_row){
        $axe = $selected_row->id_axe;
        if($this->getTable() == null)
            throw new Exception("Table is not set correctly.", 1);
        $vr = DB::table($this->getTable())
                        ->where('ETAT', 6)
                        ->where('id_domaine', '=', $selected_row->id_domaine)
                        ->where('ANNEE', '=', $selected_row->ANNEE);
        switch($axe) {
            case 1 :
            case 2 :
                $vr = $vr->where('id_axe', '=', $selected_row->id_axe)
                        ->where('id_attribution', '=', $selected_row->id_attribution)
                        ->where('id_action', '=', $selected_row->id_action);
                break;
            case  3 : 
                $vr = $vr->where('id_qualite', '=', $selected_row->id_qualite);
                break;
            case 4 :
                $vr = $vr->where('id_depense', '=', $selected_row->id_depense);
                break;
            case 5 :
                $vr = $vr->where('id_objectif', '=', $selected_row->id_objectif)
                        ->where('id_indicateur', '=', $selected_row->id_indicateur);
                break;
            default :
                throw new Exception("Error Individualizing Request Rows in AxeValidation@get_valid_rows", 1);
        }
        return $vr;
    }
    private function realisation_validee($update_state_ids, $newState){
        foreach($update_state_ids as $selected_id){
            $selected_row = DB::table($this->getTable())->where('id', '=', $selected_id)->first();
            $validated_rows = $this->get_valid_rows($selected_row);
            if($validated_rows->count() > 0){
                $validated_rh = $validated_rows->first();
                if ($validated_rh->OBJECTIF != $selected_row->OBJECTIF){
                    Session::flash('error',__('rhsd.obj exists and different').' '.__('rhsd.supprimez cette ligne').' '.__('rhsd.corriger objectif'));
                    return redirect()->back();
                }
                else{
                    $sum = $validated_rh->REALISATION + $selected_row->REALISATION;
                    $ecart = $sum - $validated_rh->OBJECTIF;
                    DB::table($this->getTable())
                            ->where('id', '=', $validated_rh->id)
                            ->update([
                                'REALISATION'=> $sum,
                                'ETAT' => $newState, 
                                'ECART' => $ecart, 
                                'id_user' => Auth::id()
                            ]);
                    $request['rhsd_id']=$selected_row->id;
                    $this->destroy((object)$request);
                }
                // NOT FIXED !!
                // Updating the 1st validated row 
                // ==> Missing one row 
                // create a copy with STATE 9 for sum
                // the STATE 9 means a sum row
                // a STATE 6 where deleted_at IS NOT NULL means a validated and used to sum step row
            }
            else{
                DB::table($this->getTable())
                    ->where('id', '=', $selected_row->id)
                    ->update([
                        'ETAT' => $newState, 
                        'id_user' => Auth::id()
                    ]);
            }
        }
    }
    public function valider(Request $request){
        try{
            $newState = $this->userValidationHelper->get_validation_states();
            $supposedState = $this->userValidationHelper->get_supposed_states();
            $update_state_ids = explode(",", $request->update_state_id);
            $public_state = $this->userValidationHelper->get_supposed_states('public');
            if($newState == $public_state){
                $this->realisation_validee($update_state_ids, $newState);
            }
            else{
                DB::table($this->getTable())
                        ->whereIn('ETAT', $supposedState)
                        ->where('REJET', 0)
                        ->whereIn('id', $update_state_ids)
                        ->update([ 
                            'ETAT' => $newState , 
                            'id_user' => Auth::id(),
                            'updated_at' => now()
                        ]);
            }
    
            (new BadgeController)->refresh_badges($request);
    
            $helper = $this->userValidationHelper;
            $public = $helper->get_supposed_states('public');

            if(count($update_state_ids) > 1){ // Just the flash message
                if($newState == $public[0]){
                    Session::flash('success',__('parametre.lignes_publiees'));
                }else{
                    Session::flash('success',__('parametre.lignes_validees'));
                }
            }else{
                if($newState == $public[0]){
                    Session::flash('success',__('parametre.ligne_publiee'));
                }else{
                    Session::flash('success',__('parametre.ligne_validee'));
                }
            }
            return redirect()->back();
        }catch(Throwable $th){
            Session::flash('error',__('parametre.erreur_validation').' EREUR: '.$th);
        }
        return redirect()->back();
    }
    public function update_all_ecarts(){ //just a helper function
        $rhsds = DB::table($this->getTable())->all();
        foreach($rhsds as $rh){
            $rh->update(['ECART' => $rh->REALISATION - $rh->OBJECTIF]);
        }
    }
    public function rejeter(Request $request){
        try{
            $update_state_ids = explode(",", $request->re_id);
            $supposedState = $this->userValidationHelper->get_supposed_states();
            DB::table($this->getTable())
                ->whereIn('ETAT', $supposedState)
                ->whereIn('id', $update_state_ids)
                ->where('REJET', 0)
                ->update([ 
                    'ETAT'      => 0,
                    'id_user'   => Auth::id(),
                    'REJET'     => 1,
                    'Motif'     => $request->motif,
                    'Description' => $request->desc,
                    'updated_at' => now()
                    ]);
            
            (new BadgeController)->refresh_badges($request);
            if(count($update_state_ids) > 1){
                Session::flash('success',__('parametre.lignes_rejetees'));
            }
            else{
                Session::flash('success',__('parametre.ligne_rejetee'));
            }
        } catch(Throwable $th){
            Session::flash('error',__('parametre.erreur_validation').' EREUR: '.$th);
        }
        return redirect()->back();
        
    }
    public function domaine_n_user($datas){
        $users = User::select('users.id','name as username');
        $dpcis = Dpci::select('dpcis.id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t', 'type as ty');
        $query = $datas->leftJoinSub($dpcis, 'dpcis', function($joinp) {
                            $joinp->on('id_domaine', '=', 'dpcis.id');})
                        ->leftJoinSub($users, 'users', function($joinu) {
                             $joinu->on('id_user', '=', 'users.id');});
        return $query;
    }
    public function get_badge_count($request){ //helper for BadgeRefresh
        $userRole = $request->session()->get('role');
        $state = $this->userValidationHelper->get_supposed_states($userRole);
        $reject = $this->userValidationHelper->get_reject_states($userRole);
        if($request->session()->has('domaine_in'))
            $domaines = $request->session()->get('domaine_in');
        else
            $domaines = null;
        
        $number = DB::table($this->getTable())->select('id')->whereIn('ETAT', $state)->whereIn('REJET', $reject);
        if($domaines != null)
            $number = $number->whereIn('id_domaine', $domaines);
        
        return $number->count();
    }

}
