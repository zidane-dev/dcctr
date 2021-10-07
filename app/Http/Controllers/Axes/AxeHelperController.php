<?php

namespace App\Http\Controllers\Axes;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MetabaseController;
use App\Http\Controllers\User\DomaineController;
use App\Http\Controllers\User\SessionController;
use App\Http\Controllers\Validation\UserValidationController;
use App\Models\Dpci;
use App\Models\Dr;
use App\Models\Secteur;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class AxeHelperController extends Controller
{
    public function get_helper($table){
        switch($table){
            case 'rhsds': 
                    return new RhsdController();
                break;
            case 'budgets': 
                    return new BudgetController();
                break;
            case 'att_procs':
                    return new AttProcController();
                break;
            case 'indic_perfs': 
                    // return new IndicPerfController();
                break;
            default:
                throw new Exception("Unknown helper @AxeHelper", 1);
                
        }
    }
    public function index($table, $request){                                        // WORKS FOR: BUDGETCONTROLLER,
        $helper = $this->get_helper($table);
        $domaine = $this->define_domaine($request);                                 // old('province') ? old('province') : session()->domaine_in
        $year = $this->define_year($request);                                       // same for year
        $data_v = $helper->get_query($domaine, $year);                              // query for public state
        $years = $this->get_years_array($data_v);                                   // fill the years array
        $dp = $this->get_domaine_by_id($request->session()->get('domaine_id'));     // get the dp
        $metabase = new MetabaseController();
        if(Auth::user()->hasPermissionTo('view-select')){
            $frame = $this->load_select_frame($metabase, $helper);
            $filters = $this->get_filter_parameters();
            return ['gate' => 1,
                    'data_v' => $data_v,  
                    'years' => $years, 
                    'filters' => $filters,  
                    'frame' => $frame, 
                    ];
        } 
        elseif(Auth::user()->hasPermissionTo('view-region')){
            $frame = $this->load_region_frame($metabase, $helper, $dp->dr_id);

        }elseif(Auth::user()->hasPermissionTo('view-province')){
            $frame = $this->load_province_frame($metabase, $helper, $dp->id);
        }
        $count = $this->get_count_achieved($table, $data_v);                         // get "achieved / total goals"

        return  ['gate' => 2,
                 'count'    => $count,
                 'years'    => $years, 
                 'dp'       => $dp,
                 'frame'    => $frame,
                 'data_v'   => $data_v
                ];
    }
    public function get_count($rows){
        $total =        $rows->count();
        $state_o =      $rows->where('ETAT', '=', 0)->count();
        $state_one =    $rows->where('ETAT', '=', 1)->count();
        $state_two =    $rows->where('ETAT', '=', 2)->count();
        $state_three =  $rows->where('ETAT', '=', 3)->count();
        $state_four =   $rows->where('ETAT', '=', 4)->count();
        $state_five =   $rows->where('ETAT', '=', 5)->count();
        $state_six =    $rows->where('ETAT', '=', 6)->count();
        
        $rows_count = [ 'rows' => $total,
        'state_o' => $state_o,
        'state_one' => $state_one,
        'state_two' => $state_two,
        'state_three' => $state_three,
        'state_four' => $state_four,
        'state_five' => $state_five,
        'state_six' => $state_six,
        ];
        $rows_count = (object) $rows_count;
        return $rows_count;
    }
    public function get_count_achieved($table, $rows){
        switch($table){
            case 'att_procs': 
                $a =    $rows->where('id_axe', 1)->count();
                $b =    $rows->where('id_axe', 2)->count();
                break;
            case 'rhsds':
            case 'budgets': 
                $a =    $rows->where('ECART', '>=', 0)->count();
                $b =    $rows->count();
                break;
            case 'indic_perfs': 
                break;
        }

        $count = ['a' => $a, 'b' => $b];
        $count = (object) $count;
        return $count;
    }
    // public function getSums($rows){ // calcul de la partie sommes de la vue graphique
        //     $sumR = [];
        //     $sumO = [];
            
        //     foreach($rows as $row){
        //         $tempR = 0;
        //         $tempO = 0;
        //         foreach($row as $axe){
        //             $tempR += $axe->REALISATION;
        //             $tempO += $axe->OBJECTIF;
        //         }
        //         array_push($sumR, $tempR);
        //         array_push($sumO, $tempO);
        //     }
        //     $sum = [$sumR, $sumO];
            
        //     return $sum;
        // }
        // public function get_ecart($realisation, $objectif){
        //     return $realisation - $objectif;
        // }
        // public function get_domaine_choice(Request $request){
        //     $regions = Dr::select('id','region_'.LaravelLocalization::getCurrentLocale().' as region')->orderBy('region', 'ASC')->get();
        //     $provinces = Dpci::select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type as t', 'type as ty')->get();
        //     return view('parametres.3.rhsds.index2', compact('regions'));
    // }
    public function get_domaineGroupByReg(Request $request){ // used in index 2
        $region = $request->region_id;
        $provinces = Dpci::select('id', 'domaine_'.LaravelLocalization::getCurrentLocale().' as name', 'type as t', 'type as ty')->where('dr_id', $region)->get();
        return response()->json(['provinces' => $provinces]);
    }
    public function get_attributionsBySec(Request $request){ 
        $secteur_id = $request->secteur_id;
        $secteur = Secteur::find($secteur_id);
        $attributions = $secteur->attribution->all();
        $locale = LaravelLocalization::getCurrentLocale()."";
        
        return response()->json(['attributions' => $attributions, 'locale'=>$locale]);
    }
    public function get_filter_parameters(){
        $provinces = Dpci::select('id', 'domaine_'.LaravelLocalization::getCurrentLocale().' as name', 'type as t', 'type as ty')->get();
        $regions = Dr::select('id','region_'.LaravelLocalization::getCurrentLocale().' as region')->orderBy('region', 'ASC')->get();

        $filters = ['regions' => $regions, 'provinces' => $provinces];
        return (object) $filters;
    }
    public function indexByQuery(Request $request){
        return redirect()->back()->withInput();
    }
    public function define_domaine(Request $request){
        if(! $request->old('province'))
            $domaine= (new DomaineController)->get_domaines();
        else
            $domaine = [$request->old('province')];
        return $domaine;
    }
    public function define_year(Request $request){
        if($request->old('year'))
            return $request->old('year');
        
        return null;
    }
    public function get_years_array($data){
        $year_grouped_data = $data->groupBy('ANNEE');
        $years = [];
        foreach($year_grouped_data as $year => $rh){
            array_push($years, $year);
        }
        return $years;
    }
    public function get_domaine_by_id($domaine_id){
        return Dpci::select('id',
                            'domaine_'.LaravelLocalization::getCurrentLocale().' as domaine',
                            'type', 
                            'type as t', 
                            'dr_id', 
                            'type as ty')
                ->where('id', $domaine_id)
                ->first();
    }
    public function load_select_frame($metabase, $helper){
        $data = $metabase->metabase_init();
        $token = $helper->get_select_token($data[0], $data[1], $data[2]);
        $frame = $metabase->get_dashboard($data[3], $token);
        return $frame;
    }
    public function load_region_frame($metabase, $helper, $region_id){
        $data = $metabase->metabase_init();
        $token = $helper->get_region_token($data[0], $data[1], $data[2], $region_id);
        $frame = $metabase->get_dashboard($data[3], $token);
        return $frame;
    }
    public function load_province_frame($metabase, $helper, $domaine){
        $data = $metabase->metabase_init();
        $token = $helper->get_province_token($data[0], $data[1], $data[2], $domaine);
        $frame = $metabase->get_dashboard($data[3], $token);
        return $frame;
    }
    public function update_all_ecarts($table){ // for developement purposes 
        $bdgs = DB::table($table)->all();       // never tested this particular line
        foreach($bdgs as $bdg){
            $ecart = $bdg->REALISATION - $bdg->OBJECTIF;
            $bdg->update(['ECART' => $ecart]);
        }
    }
    public function get_ecart($realisation, $objectif){ // + objectif atteint, - pas encore
        return ($realisation - $objectif);
    }
}
