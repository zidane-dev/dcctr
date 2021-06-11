<?php

namespace App\Http\Controllers;

use App\Models\Dpci;
use App\Models\Dr;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function get_count($userRole, $state = 0, $choice = null, $year = null, $class){
        // stateless : all data
        // state 1 : badges (how many rows to validate per role)
        // state 2 : objectifs atteints / total d'objectifs 
        // choice : choice of domaine (dcsasd)
        // year : filtered by year

        if($choice == null){
            if(Auth::user()->hasPermissionTo('view-province')) { 
                $perDomaine =   DB::table($class)->where('id_domaine', '=', Auth::user()->domaine->id)->where('REJET', '=', 0)->whereNull('deleted_at')->get();
            } // Region et ses provinces
            elseif(Auth::user()->hasPermissionTo('view-region')){ 
                if(Auth::user()->hasPermissionTo('dcsasd')){
                    $perDomaine =   DB::table($class)->where('REJET', '=', 0)->whereNull('deleted_at')->get();
                }else{
                    $domaine_group = $this->get_domaineGroup();
                    $perDomaine = DB::table($class)->whereIn('id_domaine', $domaine_group)->where('REJET', '=', 0)->whereNull('deleted_at')->get();
                }
            } 
        }// CHOICE not null
        else{
            if($choice[1] == 1){
                $perDomaine =   DB::table($class)->where('id_domaine', '=', $choice[0])->where('REJET', '=', 0)->whereNull('deleted_at')->get();
                $rows =         DB::table($class)->where('id_domaine', '=', $choice[0])->count();      
            }elseif($choice[1] == 2){
                $domaine_group = $this->get_domaineGroup($choice[0]);
                $perDomaine = DB::table($class)->whereIn('id_domaine', $domaine_group)->where('REJET', '=', 0)->whereNull('deleted_at')->get();
                $rows =       DB::table($class)->whereIn('id_domaine', $domaine_group)->count();
            }
        }
        if($year != null){
            $perDomaine = $perDomaine->where('ANNEE', $year);
            $rows = $perDomaine->count();
        }
        if(isset($perDomaine)){
            $rows =         $perDomaine->count();
            $state_o =      $perDomaine->where('ETAT', '=', 0)->count();
            $state_one =    $perDomaine->where('ETAT', '=', 1)->count();
            $state_two =    $perDomaine->where('ETAT', '=', 2)->count();
            $state_three =  $perDomaine->where('ETAT', '=', 3)->count();
            $state_four =   $perDomaine->where('ETAT', '=', 4)->count();
            $state_five =   $perDomaine->where('ETAT', '=', 5)->count();
            $state_six =    $perDomaine->where('ETAT', '=', 6)->count();
            $goal_done =    $perDomaine->where('ETAT', '=', 6)->where('ECART', '>=', 0)->count();
        }
        // For BADGES
        if($state == 1){ 
            switch($userRole){
            case 'point focal':
                return $state_o;
                break;
            case 'cs':
                return $state_one;
                break;
            case 'd-p':
                return $state_two;
                break;
            case 'd-r':
                return $state_three;
                break;
            case 'dcs':
                $state_four= DB::table($class)->where('ETAT', '=', 4)->count();
                return $state_four;
                break;
            case 'dcd':
                $state_five= DB::table($class)->where('ETAT', '=', 5)->count();
                return $state_five;
                break;   
            case 'dd':
                return 0;
                break;
            default:
                return $state_six;
            }
        } // For goals_done/total_goals
        elseif($state == 2){
            $rows_count = ['goals' => $goal_done, 'state_six' => $state_six];
            $rows_count = (object) $rows_count;
            return $rows_count;
        }

        $rows_count = [ 'rows' => $rows, 
                        'state_o' => $state_o, 
                        'state_one' => $state_one,
                        'state_two' => $state_two, 
                        'state_three' => $state_three,
                        'state_four' => $state_four, 
                        'state_five' => $state_five, 
                        'state_six' => $state_six, 
                        'goals' => $goal_done ];
        $rows_count = (object) $rows_count;
        return $rows_count;   
    }
    public function getSums($rows){ // calcul de la partie sommes de la vue graphique
        $sumR = [];
        $sumO = [];
        
        foreach($rows as $row){
            $tempR = 0;
            $tempO = 0;
            foreach($row as $axe){
                $tempR += $axe->REALISATION;
                $tempO += $axe->OBJECTIF;
            }
            array_push($sumR, $tempR);
            array_push($sumO, $tempO);
        }
        $sum = [$sumR, $sumO];
        return $sum;
    }
    public function get_count_byRows($result, $state = 0, $year = null){
        // stateless : all data
        // state 2 : objectifs atteints / total d'objectifs 
        // choice : choice of domaine (dcsasd)
        // year : filtered by year
        
        if($year != null)
            $rows = $result->where('ANNEE', $year);

        $rows =         $result->count();
        $state_o =      $result->where('ETAT', '=', 0)->count();
        $state_one =    $result->where('ETAT', '=', 1)->count();
        $state_two =    $result->where('ETAT', '=', 2)->count();
        $state_three =  $result->where('ETAT', '=', 3)->count();
        $state_four =   $result->where('ETAT', '=', 4)->count();
        $state_five =   $result->where('ETAT', '=', 5)->count();
        $state_six =    $result->where('ETAT', '=', 6)->count();
        $goal_done =    $result->where('ETAT', '=', 6)->where('ECART', '>=', 0)->count();
        
        if($state == 2){
            $rows_count = ['goals' => $goal_done, 'state_six' => $state_six];
            $rows_count = (object) $rows_count;
            return $rows_count;
        }

        $rows_count = [ 'rows' => $rows, 
                        'state_o' => $state_o, 
                        'state_one' => $state_one,
                        'state_two' => $state_two, 
                        'state_three' => $state_three,
                        'state_four' => $state_four, 
                        'state_five' => $state_five, 
                        'state_six' => $state_six, 
                        'goals' => $goal_done ];
        $rows_count = (object) $rows_count;
        return $rows_count;   
    }
    
}
