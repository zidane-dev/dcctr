<?php

namespace App\Http\Controllers;

use App\Models\AttProc;
use App\Models\Dpci;
use App\Models\Dr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\AxeHelperController;

class AttProcController extends Controller
{

    public function index($year = null){
        $userRole = (new AxeHelperController)->getUserRole();
        if(Auth::user()->hasPermissionTo('dcsasd')) {
            $regions = Dr::select('id','region_'.LaravelLocalization::getCurrentLocale().' as region')->orderBy('region', 'ASC')->get();
            $provinces = Dpci::select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type as t')->get();

            return view('parametres.3.attprocs.index2', compact('regions'));
        }
        elseif(Auth::user()->hasPermissionTo('sd')) { 
            if($year == null){
                $attproc_v = $this->getATTPROC_byRole($userRole, 'public');
                $delegproc_v = $this->getDELEGPROC_byRole($userRole, 'public');
            }
            else{
                $attproc_v = $this->getATTPROC_byRole($userRole, 'public', null, $year);
                $delegproc_v = $this->getDELEGPROC_byRole($userRole, 'public', null, $year);
                $backfirst = 1;
            }
            $attproc_sum = $attproc_v->groupBy('ANNEEOBJ');

            // $rows_count = $this->get_count($userRole, 2);
            if(isset($backfirst)){
                var_dump($backfirst);
                return view('parametres.3.attprocs.index',compact('attproc_v', 'delegproc_v', 'backfirst'));
            }
            $rows_count = $attproc_v->count();
            return view('parametres.3.attprocs.index',compact('attproc_v', 'delegproc_v', 'attproc_sum', 'rows_count'));
        }
    }
    public function indexByQuery(Request $request, $year = null){
        $helper = new AxeHelperController;
        $province = $request->province;
        $region = $request->region;
        $type = $request->type;
        if($request->year)
            $year = $request->year;
        $query = [$province, $region, $type]; 
        $dp = Dpci::select('domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t')->where('id', $province)->first();
        array_push($query, $dp->domaine);
        array_push($query, $dp->type);  
        $userRole = $helper->getUserRole();
        if($year != null)
            $rh_v = $this->getATTPROC_byRole($userRole, 'public', $province, $year);
        else
            $rh_v = $this->getATTPROC_byRole($userRole, 'public', $province);
        $rh_sum = $rh_v->groupBy('ANNEESD');
        $sum = $this->getSums($rh_sum);
        if($dp->t == 'DP' || $dp->t == 'DC')
            // $rows_count = $this->get_count($userRole, 2, [$province, 1]);
            $rows_count = 0;
        else
            // $rows_count = $this->get_count($userRole, 2, [$province, 2]);
            $rows_count = 0;
       
        $regions = Dr::select('id','region_'.LaravelLocalization::getCurrentLocale().' as region')->orderBy('region', 'ASC')->get();
        if($request->year){
            $backfirst = 1;
            return view('parametres.3.attprocs.index',compact('rh_v', 'rows_count', 'rh_sum', 'sum', 'query', 'backfirst', 'dp'));
        }
        return view('parametres.3.attprocs.index',compact('rh_v', 'rows_count', 'rh_sum', 'sum', 'query', 'regions', 'type', 'dp'));
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
    public function getATTPROC_byRole($userRole, $public = null, $choice = null, $year = null){
        // 1 - Get RH with corresponding ETATSD and REJETSD
        if($public == 'public'){ // rows for index
            $attproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 6)
                                        ->where('REJET', '=', 0)
                                        ->where('id_axe' , '=', 1);
            if($year != null){
                $attproc = $attproc->where('ANNEEOBJ', '=', $year);
            }
        }
        else{
            switch ($userRole) { // rows for validation
                case 's-a':
                    $attproc = AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1);
                    break;
                case 'point focal':
                    $attproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=',0)
                                        ->WhereIn('REJET',[0,1]);
                    break;
                case 'cs': 
                    $attproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->whereIn('ETAT', [0,1])
                                        ->WhereIn('REJET',[0,1]);
                    break;
                case 'd-p':
                    $attproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 2)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'd-r':
                    $attproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 3)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'dcs':
                    $attproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 4)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'dcd':
                    $attproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 5)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'dd':
                    $attproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 6)
                                        ->Where('REJET', '=', 0);
                    break;
                default:
                    //fix
                    echo('ERROR RH SELECT');     
            }
        }
        
        // 2- get corresponding DPCIS
        $helper = new AxeHelperController;
        if($userRole == 's-a' || $userRole == 'd-r') {
            $domaine_group = $helper->get_domaineGroup();
            $attproc = $attproc->whereIn('id_domaine', $domaine_group);
        } 
        elseif($userRole == 'dd' || $userRole == 'dcs' || $userRole == 'dcd') {
            if($choice != null){
                $dom = Dpci::select('id', 'type as t')->where('id', '=', $choice)->first();
                if($dom->t == 'DR' ){
                    $domaine_group = $helper->get_domaineGroup($choice);
                    $attproc = $attproc->whereIn('id_domaine', $domaine_group);
                }
                elseif($dom->t == 'DP' || $dom->t == 'DC'){
                    $attproc = $attproc->where('id_domaine', '=', $choice);
                }
            }
        }
        else {
            $attproc = $attproc->where('id_domaine', '=', Auth::user()->domaine->id);
        }
        
        // 3- get relationships (names for the foreign ids)
        $attprocs = $attproc->with(
            ['attribution' => function($q){
                $q->select('id','attribution_'.LaravelLocalization::getCurrentLocale().' as attribution', 'secteur_id')->with(
                    ['secteur' => function($s){
                      $s->select('id', 'secteur_'.LaravelLocalization::getCurrentLocale().' as secteur');  
                    }]);
            }])->with(
            ['domaine' => function($d){
                $d->select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t');
            }])->with(
            // ['niveau' => function($l){
                    // $l->select('id','name_'.LaravelLocalization::getCurrentLocale().' as niveau');
            // }])->with( 
            ['niveau' => function($l){
                $l->select('id','name as niveau');
            }])->with( 
            ['action' => function($d){
                $d->select('id','action_'.LaravelLocalization::getCurrentLocale().' as action');
            }])->with(
            ['axe' => function($a){
                $a->select('id','axe_'.LaravelLocalization::getCurrentLocale().' as axe');
            }])->with(
            ['user' => function($u){
                $u->select('id','name');
            }]);

        if($public == 'public'){
            $attprocs= $attprocs->orderBy('ANNEERLS','ASC')->get();
        }else{
            $attprocs= $attprocs->orderBy('date','DESC')->get();
        }
        // attprocs by user domaine range, and corresponding states.
        return $attprocs;
    } 
    public function getDELEGPROC_byRole($userRole, $public = null, $choice = null, $year = null){
        // 1 - Get RH with corresponding ETATSD and REJETSD
        if($public == 'public'){ // rows for index
            $delegproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 6)
                                        ->where('REJET', '=', 0)
                                        ->where('id_axe' , '=', 2);
            if($year != null){
                $delegproc = $delegproc->where('ANNEEOBJ', '=', $year);
            }
        }
        else{
            switch ($userRole) { // rows for validation
                case 's-a':
                    $delegproc = AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1);
                    break;
                case 'point focal':
                    $delegproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=',0)
                                        ->WhereIn('REJET',[0,1]);
                    break;
                case 'cs': 
                    $delegproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->whereIn('ETAT', [0,1])
                                        ->WhereIn('REJET',[0,1]);
                    break;
                case 'd-p':
                    $delegproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 2)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'd-r':
                    $delegproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 3)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'dcs':
                    $delegproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 4)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'dcd':
                    $delegproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 5)
                                        ->Where('REJET', '=', 0);
                    break;
                case 'dd':
                    $delegproc =  AttProc::select('id','STATUT','ANNEERLS','ANNEEOBJ','ETAT','REJET','id_attribution','id_domaine','id_axe', 'id_action', 'id_level','id_user', 'updated_at as date')
                                        ->where('STATUT', '=', 1)
                                        ->where('ETAT', '=', 6)
                                        ->Where('REJET', '=', 0);
                    break;
                default:
                    //fix
                    echo('ERROR RH SELECT');     
            }
        }
        
        // 2- get corresponding DPCIS
        $helper = new AxeHelperController;
        if($userRole == 's-a' || $userRole == 'd-r') {
            $domaine_group = $helper->get_domaineGroup();
            $delegproc = $delegproc->whereIn('id_domaine', $domaine_group);
        } 
        elseif($userRole == 'dd' || $userRole == 'dcs' || $userRole == 'dcd') {
            if($choice != null){
                $dom = Dpci::select('id', 'type as t')->where('id', '=', $choice)->first();
                if($dom->t == 'DR' ){
                    $domaine_group = $helper->get_domaineGroup($choice);
                    $delegproc = $delegproc->whereIn('id_domaine', $domaine_group);
                }
                elseif($dom->t == 'DP' || $dom->t == 'DC'){
                    $delegproc = $delegproc->where('id_domaine', '=', $choice);
                }
            }
        }
        else {
            $delegproc = $delegproc->where('id_domaine', '=', Auth::user()->domaine->id);
        }
        
        // 3- get relationships (names for the foreign ids)
        $delegprocs = $delegproc->with(
            ['attribution' => function($q){
                $q->select('id','attribution_'.LaravelLocalization::getCurrentLocale().' as attribution', 'secteur_id')->with(
                    ['secteur' => function($s){
                      $s->select('id', 'secteur_'.LaravelLocalization::getCurrentLocale().' as secteur');  
                    }]);
            }])->with(
            ['domaine' => function($d){
                $d->select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t');
            }])->with(
            // ['niveau' => function($l){
                    // $l->select('id','name_'.LaravelLocalization::getCurrentLocale().' as niveau');
            // }])->with( 
            ['niveau' => function($l){
                $l->select('id','name as niveau');
            }])->with( 
            ['action' => function($d){
                $d->select('id','action_'.LaravelLocalization::getCurrentLocale().' as action');
            }])->with(
            ['axe' => function($a){
                $a->select('id','axe_'.LaravelLocalization::getCurrentLocale().' as axe');
            }])->with(
            ['user' => function($u){
                $u->select('id','name');
            }]);

        if($public == 'public'){
            $delegprocs= $delegprocs->orderBy('ANNEERLS','ASC')->get();
        }else{
            $delegprocs= $delegprocs->orderBy('date','DESC')->get();
        }
        // attprocs by user domaine range, and corresponding states.
        return $delegprocs;
    } 


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
