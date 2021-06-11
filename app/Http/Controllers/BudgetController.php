<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Dpci;
use App\Models\Dr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BudgetController extends Controller
{
    private $table = "budgets";
    // private $axehelper = (new AxeHelperController);
    public function index($year = null){
        $userRole = (new AxeHelperController)->getUserRole();
        if(Auth::user()->hasPermissionTo('dcsasd')) {
            $regions = Dr::select('id','region_'.LaravelLocalization::getCurrentLocale().' as region')->orderBy('region', 'ASC')->get();
            $provinces = Dpci::select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type as t', 'type as ty')->get();

            return view('parametres.3.rhsds.index2', compact('regions'));
        }
        elseif(Auth::user()->hasPermissionTo('sd')) { 
            if($year == null){
                $bdg_v = $this->getBDG_byRole($userRole, 'public');
                // $rows_count = (new AxeHelperController)->get_count($userRole, 2, null, null, $this->table);
                $rows_count = (new AxeHelperController)->get_count_byRows($bdg_v, 2);
            }
            else{
                $backfirst = 1;
                $bdg_v = $this->getBDG_byRole($userRole, 'public', null, $year);  
                $rows_count = (new AxeHelperController)->get_count_byRows($bdg_v, 2);
            }
            $bdg_sum = $bdg_v->groupBy('ANNEESD');
            $sum = (new AxeHelperController)->getSums($bdg_sum);
            if(isset($backfirst)){
                return view('parametres.3.budgets.index',compact('bdg_v', 'rows_count', 'bdg_sum', 'sum', 'backfirst'));
            }
            return view('parametres.3.budgets.index',compact('bdg_v', 'rows_count', 'bdg_sum', 'sum'));
        }
    }
    public function indexByQuery(Request $request, $year = null){
        $province = $request->province;
        $region = $request->region;
        $type = $request->type;
        if($request->year)
            $year = $request->year;
        $query = [$province, $region, $type]; 
        $dp = Dpci::select('domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t', 'type as ty')->where('id', $province)->first();
        array_push($query, $dp->domaine);
        array_push($query, $dp->type);  
        $userRole = $this->getUserRole();
        if($year != null)
            $bdg_v = $this->getBDG_byRole($userRole, 'public', $province, $year);
        else
            $bdg_v = $this->getBDG_byRole($userRole, 'public', $province);
        $bdg_sum = $bdg_v->groupBy('ANNEESD');
        $sum = $this->getSums($bdg_sum);
        if($dp->t == 'DP' || $dp->t == 'DC')
            if($year == null)
                $rows_count = $this->get_count($userRole, 2, [$province, 1], null, $this->table);
            else
                $rows_count = $this->get_count($userRole, 2, [$province, 1], null, $year);  // too many args??
        else
            if($year == null)
                $rows_count = $this->get_count($userRole, 2, [$province, 2], null, $this->table);
            else
                $rows_count = $this->get_count($userRole, 2, [$province, 2], null, $year); // too many args??
       
        $regions = Dr::select('id','region_'.LaravelLocalization::getCurrentLocale().' as region')->orderBy('region', 'ASC')->get();
        if($request->year){
            $backfirst = 1;
            return view('parametres.3.rhsds.index',compact('rh_v', 'rows_count', 'rh_sum', 'sum', 'query', 'backfirst', 'dp'));
        }
        return view('parametres.3.rhsds.index',compact('rh_v', 'rows_count', 'rh_sum', 'sum', 'query', 'regions', 'type', 'dp'));
    }
    public function indexYear(Request $request){
        $year=$request->year;
        if(Auth::user()->hasPermissionTo('dcsasd')){
            //$request should containe type, region & province
            return $this->indexByQuery($request, $year);
        }else{
            return $this->index($year);
        }
    }
    public function get_validation(Request $request){
        $this->getBadgeRefresh($request);
        $userRole = $this->getUserRole();
        $datas = $this->getBDG_byRole($userRole);
        //////////////////////////////////////////////////////////////////////////////// COUNTS
        $rows_count = $this->get_count($userRole);
        
        return view('validations.rhs', compact('datas','rows_count'));
    }
    public function getBDG_byRole($userRole, $public = null, $choice = null, $year = null){
        // 1 - Get RH with corresponding ETATSD and REJETSD
        if($public == 'public'){ // rows for index
            $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETAT', '=',6)
                                        ->Where('REJET', '=',0);
            if($year != null){
                $bdg = $bdg->where('ANNEESD', '=', $year);
            }
        }
        else{
            switch ($userRole) { // rows for validation
                case 's-a':
                    $bdg = Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date');
                    break;
                    //THIS BETTER
                // case 'public':
                //     $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                //                         ->where('ETAT', '=',6)
                //                         ->Where('REJET', '=',0);
                //     break;
                case 'point focal':
                    $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETAT', '=', 0)
                                        ->WhereIn('REJET',[0,1]);
                    break;
                case 'cs': 
                    $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->whereIn('ETAT', [0,1])
                                        ->WhereIn('REJET',[0,1]);
                    break;
                case 'd-p':
                    $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETAT', '=', 2)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'd-r':
                    $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETAT', '=', 3)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'dcs':
                    $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETAT', '=', 4)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'dcd':
                    $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETAT', '=', 5)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'dd':
                    $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETAT', '=', 5)
                                        ->Where('REJET', '=', 0);
                    break;
                default:
                    //fix
                    echo('ERROR RH SELECT');     
            }
        }
        
        // 2- get corresponding DPCIS
        if($userRole == 's-a' || $userRole == 'd-r') {
            $domaine_group = (new AxeHelperController)->get_domaineGroup(); 
            $bdg = $bdg->whereIn('id_domaine', $domaine_group);
        } 
        elseif($userRole == 'dd' || $userRole == 'dcs' || $userRole == 'dcd') {
            if($choice != null){
                $dom = Dpci::select('id', 'type as t', 'type as ty')->where('id', '=', $choice)->first();
                if($dom->t == 'DR' ){
                    $domaine_group = (new AxeHelperController)->get_domaineGroup($choice);
                    
                    $bdg = $bdg->whereIn('id_domaine', $domaine_group);
                }
                elseif($dom->t == 'DP' || $dom->t == 'DC'){
                    $bdg = $bdg->where('id_domaine', '=', $choice);
                }
            }
        }
        else {
            $bdg = $bdg->where('id_domaine', '=', Auth::user()->domaine->id);
        }
        
        // 3- get relationships (names for the foreign ids)
        $bdgs = $bdg->with(
            ['depense' => function($q){
                $q->select('id','depense_'.LaravelLocalization::getCurrentLocale().' as depense');
            }])->with(
            ['domaine' => function($d){
                $d->select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t', 'type as ty');
            }])->with(
            ['axe' => function($a){
                $a->select('id','axe_'.LaravelLocalization::getCurrentLocale().' as axe');
            }])->with(
            ['user' => function($u){
                $u->select('id','name');
            }]);

        if($public == 'public'){
            $bdgs= $bdgs->orderBy('ANNEE_BDG','ASC')->get();
        }else{
            $bdgs= $bdgs->orderBy('date','DESC')->get();
        }
        // rhsds by user domaine range, and corresponding states.
        return $bdgs;
    }  
    public function getRH_byDom(Request $request){ //unused
        $userRole = $this->getUserRole();
        $domaine = $request->domaine;
        $dom = Dpci::where('id', '=', $domaine);
        switch($userRole){
            case 'dcs':
                $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                    ->where('ETATSD', '=',4)
                                    ->Where('REJETSD', '=',0);
                break;
            case 'dcd':
                $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                    ->where('ETATSD', '=',5)
                                    ->Where('REJETSD', '=',0);
                break;
            case 'dd':
                $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                    ->where('ETATSD', '=',6)
                                    ->Where('REJETSD', '=',0);
                break;
            case 'public':
                $bdg =  Budget::select('id','OBJECTIF_BDG','REALISATION_BDG','ANNEE_BDG', 'ECART','ETAT','REJET','id_depense','id_domaine','id_axe','id_user','updated_at as date')
                                    ->where('ETATSD', '=',7)
                                    ->Where('REJETSD', '=',0);
                break;
            default:
                //fix
                echo('ERROR RH SELECT');   
        }
        if($dom->t = 'DR') {
            $domaine_group = (new AxeHelperController)->get_domaineGroup($domaine);
            $bdg = $bdg->whereIn('id_domaine', $domaine_group);
        } else {
            $bdg = $bdg->where('id_domaine', '=', Auth::user()->domaine->id);
        }
        $bdgs = $bdg->with(
            ['depense' => function($q){
                $q->select('id','depense_'.LaravelLocalization::getCurrentLocale().' as depense');
            }])->with(
            ['domaine' => function($d){
                $d->select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t', 'type as ty');
            }])->with(
            ['axe' => function($a){
                $a->select('id','axe_'.LaravelLocalization::getCurrentLocale().' as axe');
            }])->with(
            ['user' => function($u){
                $u->select('id','name');
            }]);
        $bdgs= $bdgs->orderBy('ANNEE_BDG','ASC')->get();
        return $bdgs;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
