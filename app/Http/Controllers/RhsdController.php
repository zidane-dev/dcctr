<?php

namespace App\Http\Controllers;

use App\Models\Rhsd;
use App\Models\Qualite;
use App\Models\Dpci;
use App\Models\Axe;
use App\Models\Dr;
use App\User;

use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class RhsdController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:access-rhsds']);
        $this->middleware(['permission:list-rhsds'])->only('index');
        $this->middleware(['permission:create-rhsds'])->only(['create', 'store']);
        $this->middleware(['permission:edit-rhsds'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-rhsds'])->only('destroy');

    }
    public function index($year = null){
        $userRole = $this->getUserRole();
        if(Auth::user()->hasPermissionTo('dcsasd')) {
            $regions = Dr::select('id','region_'.LaravelLocalization::getCurrentLocale().' as region')->orderBy('region', 'ASC')->get();
            $provinces = Dpci::select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type as t', 'type as ty')->get();

            return view('parametres.3.rhsds.index2', compact('regions'));
        }
        elseif(Auth::user()->hasPermissionTo('sd')) { 
            if($year == null){
                $rh_v = $this->getRH_byRole($userRole, 'public');
                $rows_count = $this->get_count($userRole, 2);
            }
            else{
                $rh_v = $this->getRH_byRole($userRole, 'public', null, $year);
                $backfirst = 1;
                $rows_count = $this->get_count($userRole, 2, null, $year);
            }
            $rh_sum = $rh_v->groupBy('ANNEESD');
            $sum = $this->getSums($rh_sum);
            if(isset($backfirst)){
                return view('parametres.3.rhsds.index',compact('rh_v', 'rows_count', 'rh_sum', 'sum', 'backfirst'));
            }
            return view('parametres.3.rhsds.index',compact('rh_v', 'rows_count', 'rh_sum', 'sum'));
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
            $rh_v = $this->getRH_byRole($userRole, 'public', $province, $year);
        else
            $rh_v = $this->getRH_byRole($userRole, 'public', $province);
        $rh_sum = $rh_v->groupBy('ANNEESD');
        $sum = $this->getSums($rh_sum);
        if($dp->t == 'DP' || $dp->t == 'DC')
            if($year == null)
                $rows_count = $this->get_count($userRole, 2, [$province, 1]);
            else
                $rows_count = $this->get_count($userRole, 2, [$province, 1], null, $year);
        else
            if($year == null)
                $rows_count = $this->get_count($userRole, 2, [$province, 2]);
            else
                $rows_count = $this->get_count($userRole, 2, [$province, 2], null, $year);
       
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
        $rhsds = $this->getRH_byRole($userRole);
        //////////////////////////////////////////////////////////////////////////////// COUNTS
        $rows_count = $this->get_count($userRole);
        
        return view('parametres.3.rhsds.validation', compact('rhsds','rows_count'));
    }
    public function getRH_byRole($userRole, $public = null, $choice = null, $year = null){
        // 1 - Get RH with corresponding ETATSD and REJETSD
        if($public == 'public'){ // rows for index
            $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETATSD', '=',6)
                                        ->Where('REJETSD', '=',0);
            if($year != null){
                $rh = $rh->where('ANNEESD', '=', $year);
            }
        }
        else{
            switch ($userRole) { // rows for validation
                case 's-a':
                    $rh = Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date');
                    break;
                case 'point focal':
                    $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETATSD', '=',0)
                                        ->WhereIn('REJETSD',[0,1]);
                    break;
                case 'cs': 
                    $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->whereIn('ETATSD', [0,1])
                                        ->WhereIn('REJETSD',[0,1]);
                    break;
                case 'd-p':
                    $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETATSD', '=',2)
                                        ->Where('REJETSD', '=',0);
                    break;
                case 'd-r':
                    $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETATSD', '=',3)
                                        ->Where('REJETSD', '=',0);
                    break;
                case 'dcs':
                    $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETATSD', '=',4)
                                        ->Where('REJETSD', '=',0);
                    break;
                case 'dcd':
                    $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETATSD', '=',5)
                                        ->Where('REJETSD', '=',0);
                    break;
                case 'dd':
                    $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                        ->where('ETATSD', '=',5)
                                        ->Where('REJETSD', '=',0);
                    break;
                default:
                    //fix
                    echo('ERROR RH SELECT');     
            }
        }
        
        // 2- get corresponding DPCIS
        if($userRole == 's-a' || $userRole == 'd-r') {
            $domaine_group = $this->get_domaineGroup(); 
            $rh = $rh->whereIn('id_domaine', $domaine_group);
        } 
        elseif($userRole == 'dd' || $userRole == 'dcs' || $userRole == 'dcd') {
            if($choice != null){
                $dom = Dpci::select('id', 'type as t', 'type as ty')->where('id', '=', $choice)->first();
                if($dom->t == 'DR' ){
                    $domaine_group = $this->get_domaineGroup($choice);
                    
                    $rh = $rh->whereIn('id_domaine', $domaine_group);
                }
                elseif($dom->t == 'DP' || $dom->t == 'DC'){
                    $rh = $rh->where('id_domaine', '=', $choice);
                }
            }
        }
        else {
            $rh = $rh->where('id_domaine', '=', Auth::user()->domaine->id);
        }
        
        // 3- get relationships (names for the foreign ids)
        $rhsds = $rh->with(
            ['qualite' => function($q){
                $q->select('id','qualite_'.LaravelLocalization::getCurrentLocale().' as qualite');
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
            $rhsds= $rhsds->orderBy('ANNEESD','ASC')->get();
        }else{
            $rhsds= $rhsds->orderBy('date','DESC')->get();
        }
        // rhsds by user domaine range, and corresponding states.
        return $rhsds;
    }  
    public function getRH_byDom(Request $request){ //unused
        $userRole = $this->getUserRole();
        $domaine = $request->domaine;
        $dom = Dpci::where('id', '=', $domaine);
        switch($userRole){
            case 'dcs':
                $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                    ->where('ETATSD', '=',4)
                                    ->Where('REJETSD', '=',0);
                break;
            case 'dcd':
                $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                    ->where('ETATSD', '=',5)
                                    ->Where('REJETSD', '=',0);
                break;
            case 'dd':
                $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','Description','Motif', 'updated_at as date')
                                    ->where('ETATSD', '=',6)
                                    ->Where('REJETSD', '=',0);
                break;
            case 'public':
                $rh =  Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ECARTSD','ETATSD','REJETSD','id_qualite','id_domaine','id_axe','id_user','updated_at as date')
                                    ->where('ETATSD', '=',7)
                                    ->Where('REJETSD', '=',0);
                break;
            default:
                //fix
                echo('ERROR RH SELECT');   
        }
        if($dom->t = 'DR') {
            $domaine_group = $this->get_domaineGroup($domaine);
            $rh = $rh->whereIn('id_domaine', $domaine_group);
        } else {
            $rh = $rh->where('id_domaine', '=', Auth::user()->domaine->id);
        }
        $rhsds = $rh->with(
            ['qualite' => function($q){
                $q->select('id','qualite_'.LaravelLocalization::getCurrentLocale().' as qualite');
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
        $rhsds= $rhsds->orderBy('ANNEESD','ASC')->get();
        return $rhsds;
    }
    public function create(){
        $qualites = Qualite::select('id','qualite_'.LaravelLocalization::getCurrentLocale().' as qualite')->orderBy('id','ASC')->cursor();
        $domaines = Dpci::select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type')->orderBy('id','ASC')->cursor();
        $axes = Axe::select('id','axe_'.LaravelLocalization::getCurrentLocale().' as axes')->orderBy('id','ASC')->cursor();

        return view('parametres.3.rhsds.create',compact('qualites','domaines','axes'));
    }
    public function store(Request $request){
        if($request->isMethod('POST')){
            
            if($request->date_creation){
                $year =Carbon::createFromFormat('yy',$request->date_creation)->format('Y');}
            elseif($request->annee)
                {$year = $request->annee;}
            
            $validated_rhs = Rhsd::where('ETATSD', 6)
                                    ->where('id_domaine', '=', $request->domaine)
                                    ->where('id_qualite', '=', $request->qualite)
                                    ->where('ANNEESD', '=', $year);
            if($validated_rhs->count() > 0){
                $validated_rh = $validated_rhs->first();
                if($validated_rh->OBJECTIFSD != $request->objectif){
                    Session::flash('error',__('rhsd.obj exists and different')."<br/>".__('rhsd.supprimez cette ligne'));
                    return redirect()->back();
                }
            }
            
            $ecart = $request->realisation - $request->objectif;
            Rhsd::create([
                'id_qualite' => $request->qualite,
                'id_domaine' => $request->domaine,
                'id_axe' => $request->axe,
                'ANNEESD' => $year,
                'OBJECTIFSD' => $request->objectif,
                'REALISATIONSD' => $request->realisation,
                'ECARTSD' => $ecart,
                'ETATSD' => 0,
                'REJETSD' => 0,
                'id_user' => Auth::id(),
            ]);

            Session::flash('success',__('rhsd.rhsd success in add'));
            $this->getBadgeRefresh($request);

            return back();
        }
    }
    public function nouvelle_realisation($id){
        $data = $this->edit($id, 1);
        $rhsd = $data['rhsd'];
        $qualites = $data['qualites'];
        $domaines = $data['domaines'];
        $axes = $data['axes'];
        $fullDate = $data['fullDate'];
        return view('parametres.3.rhsds.newreal', compact('rhsd', 'qualites', 'domaines', 'axes', 'fullDate'));
    }
    public function show($id){
        // donut REALISATION - OBJECTIF per Quality. by DOMAINE
        // nb of rows awaiting validation
        // nb of rows validated
        // attributions ? more data ?
        $rh_selected =  Rhsd::where('id', '=', $id)->first();
        $rh = Rhsd::select('id','OBJECTIFSD','REALISATIONSD','ANNEESD', 'ETATSD','REJETSD','id_qualite','id_domaine','id_user','Description','Motif', 'updated_at as date');
        $uss = User::where('id', Auth::id())->first();
        $userRole = $uss->roles->pluck('name')->first();
        
        $rh = $rh->where('id_domaine', '=', $rh_selected->id_domaine)->where('id_qualite', '=', $rh_selected->id_qualite);

        $rhsds = $rh->with(
            ['qualite' => function($q){
                $q->select('id','qualite_'.LaravelLocalization::getCurrentLocale().' as qualite');
            }])->with(
            ['domaine' => function($d){
                $d->select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t', 'type as ty');
            }])->with(
            ['user' => function($u){
                $u->select('id','name');
            }])
            ->orderBy('date','DESC')->get();
        return view('parametres.3.rhsds.show', compact('rhsds'));
    }
    public function edit($id, $flag=null){
        $rhsd = Rhsd::find($id);

        if(!$rhsd){
            return redirect()->route('rhsd.index');
        }
        
        $qualites = Qualite::select('id','qualite_'.LaravelLocalization::getCurrentLocale().' as qualite')->cursor();
        $domaines = Dpci::select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type')->cursor();
        $axes = Axe::select('id','axe_'.LaravelLocalization::getCurrentLocale().' as axe')->cursor();
        //this needs to go if we are to insert rows with dates to begin with

        if($rhsd->created_at != NULL )
            $fullDate = Carbon::createFromFormat('Y-m-d H:m:s',$rhsd->created_at)->format('Y-m-d');
        else
            $fullDate = '00-00-00';

        ////////////////////////////////////////////////////////////////////
        if($flag == 1){
            unset($rhsd->REALISATIONSD);
        }
        ////////////////////////////////////////////////////////////////////
        return view('parametres.3.rhsds.edit', compact('rhsd', 'qualites', 'domaines', 'axes', 'fullDate'));
    }
    public function edit_goal(Request $request){

        $rhsd = Rhsd::find($request->id);
        if(!$rhsd){
            return redirect()->route('rhsd.index');
        }
        $qualites = Qualite::select('id','qualite_'.LaravelLocalization::getCurrentLocale().' as qualite')->cursor();
        $domaines = Dpci::select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type')->cursor();
        $axes = Axe::select('id','axe_'.LaravelLocalization::getCurrentLocale().' as axe')->cursor();

        return view('parametres.3.rhsds.editgoal', compact('rhsd', 'qualites', 'domaines', 'axes'));
    }
    public function update(Request $request, $id){
        $rhsd = Rhsd::find($id);
        $rhsd->update([
            'id_qualite' => $request->qualite,
            'id_domaine' => $request->domaine,
            'id_axe' => $request->axe,
            'ANNEESD' => $request->ANNEESD,
            'OBJECTIFSD' => $request->objectif,
            'REALISATIONSD' => $request->realisation,
            'ECARTSD' => $request->ecart,
            'id_user' => Auth::id(),
            
            'ETATSD' => 0,
            'REJETSD' => 0,
            'Motif' => '',
            'Description' => '',
            'updated_at' => now()
        ]);

        Session::flash('success',__('rhsd.rhsd success in edit'));
        $this->getBadgeRefresh($request);

        return $this->get_validation($request);
    }
    public function update_goal(Request $request){
        // dd($request);
        $rh = Rhsd::where('id', '=', $request->id)->first();
        
        Rhsd::where('id_domaine', '=', $rh->id_domaine)
            ->where('id_qualite', '=', $rh->id_qualite)
            ->where('ANNEESD', '=', $rh->ANNEESD)
            ->update(['OBJECTIFSD' => $request->newObjectif, 'ECARTSD' => ($rh->REALISATIONSD-$request->newObjectif)]);
        return redirect()->route('rhs.index');
    }
    public function update_etat(Request $request){

        $update_state_ids = explode(",", $request->update_state_id);
        $uss = User::where('id',Auth::id())->first();
        $userRole = $uss->roles->pluck('name')->first();
        // return ($userRole);
        //the role of user authentifié
        switch ($userRole) {
            case 's-a':         echo ('Task unavailable');                   break;
            case 'point focal': $newState = 1;  $supposedState = [0];        break;
            case 'cs':          
                if($uss->domaine->type === "Direction Régionale"){
                    $newState = 3;  $supposedState = [0, 1];     }                  // cs r
                else{
                    $newState = 2;  $supposedState = [0, 1];     }                  // cs p
                break; // sd
            case 'd-p':         $newState = 3;  $supposedState = [2];        break; // sd p
            case 'd-r':         $newState = 4;  $supposedState = [3];        break; // sd r
            case 'dcs':         $newState = 5;  $supposedState = [4];        break; // dc cs
            case 'dcd':         $newState = 6;  $supposedState = [5];        break; // dc cd
            case 'dcsasd':      $newState = 5;  $supposedState = [6];        break; // dc d
            default:            echo ('Unauthorized guest');                 //fix        
        }
        if($newState == 6){
            foreach($update_state_ids as $selected_id){
                $selected_rh = Rhsd::where('id', '=', $selected_id)->first();
                $validated_rhs = Rhsd::where('ETATSD', 6)
                                        ->where('id_domaine', '=', $selected_rh->id_domaine)
                                        ->where('id_qualite', '=', $selected_rh->id_qualite)
                                        ->where('ANNEESD', '=', $selected_rh->ANNEESD);
                if($validated_rhs->count() > 0){
                    $validated_rh = $validated_rhs->first();
                    if($validated_rh->OBJECTIFSD != $selected_rh->OBJECTIFSD){
                        Session::flash('error',__('rhsd.obj exists and different').' '.__('rhsd.supprimez cette ligne'));
                        return redirect()->back();
                    }else{
                        $sum = $validated_rh->REALISATIONSD + $selected_rh->REALISATIONSD;
                        $ecart = $sum - $validated_rh->OBJECTIFSD;
                        Rhsd::where('id', '=', $validated_rh->id)->update(['REALISATIONSD'=> $sum,'ETATSD' => $newState, 'ECARTSD' => $ecart, 'id_user' => Auth::id()]);
                        $request['rhsd_id']=$selected_rh->id;
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
                    Rhsd::where('id', '=', $selected_rh->id)->update(['ETATSD' => $newState, 'id_user' => Auth::id()]);
                }
            }
        }
        else{
        Rhsd::whereIn('ETATSD', $supposedState)->where('REJETSD', 0)
            ->whereIn('id', $update_state_ids)->update([ 'ETATSD' => $newState , 'id_user' => Auth::id()]);
        }
        $rhsds = $this->get_count($userRole, 1);
        session(['rh_count' => $rhsds]);

        $this->getBadgeRefresh($request);
        return redirect()->back();
    }
    public function update_all_ecarts(){ //just a helper function
        $rhsds = Rhsd::all();
        foreach($rhsds as $rh){
            $rh->update(['ECARTSD' => $rh->REALISATIONSD - $rh->OBJECTIFSD]);
        }
    }
    public function rejection(Request $request){
        $update_state_ids = explode(",", $request->re_id);
        $uss = User::where('id',Auth::id())->first();
        $userRole = $uss->roles->pluck('name')->first();
        // return ($userRole);
        //the role of user authentifié
        switch ($userRole) {
            case 's-a':         echo ('Task unavailable');      break;
            case 'point focal': $supposedState = [0];           break;
            case 'cs':          $supposedState = [0, 1];        break;
            case 'd-p':         $supposedState = [2];           break;
            case 'd-r':         $supposedState = [3];           break;
            case 'ss':          $supposedState = [4];           break;
            case 'dcsasd':      $supposedState = [4,5,6];       break;
            case 'mlm':         $supposedState = [5];           break;
            case 'management':  $supposedState = [6];           break;
            default:            echo('ERROR RH SELECT');     //fix the def
        }
        Rhsd::whereIn('ETATSD', $supposedState)->where('REJETSD', 0)
            ->whereIn('id', $update_state_ids)->update([ 'ETATSD' => 0 ,
                                                         'id_user' => Auth::id(),
                                                         'REJETSD' => 1,
                                                         'Motif' => $request->motif,
                                                         'Description' => $request->desc
                                                         ]);
        
        $this->getBadgeRefresh($request);
        return redirect()->back();
    }
    public function destroy(Request $request){
        $rhsd = Rhsd::find($request->rhsd_id);
        $rhsd->delete();
        Session::flash('success', __('rhsd.rhsd success in supprimer'));
        return redirect()->route('rhs.index');
    }
    public function get_county($rh){

    }
    public function get_count($userRole, $state = 0, $choice = null, $year = null){
        // stateless : all data
        // state 1 : badges (how many rows to validate per role)
        // state 2 : objectifs atteints / total d'objectifs 
        if($choice == null){
            if(Auth::user()->hasPermissionTo('view-province')) { 
                $perDomaine =   DB::table('rhsds')->where('id_domaine', '=', Auth::user()->domaine->id)->where('REJETSD', '=', 0)->whereNull('deleted_at')->get();
            } // Region et ses provinces
            elseif(Auth::user()->hasPermissionTo('view-region')){ 
                if(Auth::user()->hasPermissionTo('dcsasd')){
                    $perDomaine =   DB::table('rhsds')->where('REJETSD', '=', 0)->whereNull('deleted_at')->get();
                }else{
                    $domaine_group = $this->get_domaineGroup();
                    $perDomaine = DB::table('rhsds')->whereIn('id_domaine', $domaine_group)->where('REJETSD', '=', 0)->whereNull('deleted_at')->get();
                }
            } 
        }// CHOICE not null
        else{
            if($choice[1] == 1){
                $perDomaine =   DB::table('rhsds')->where('id_domaine', '=', $choice[0])->where('REJETSD', '=', 0)->whereNull('deleted_at')->get();
                $rows =         DB::table('rhsds')->where('id_domaine', '=', $choice[0])->count();      
            }elseif($choice[1] == 2){
                $domaine_group = $this->get_domaineGroup($choice[0]);
                $perDomaine = DB::table('rhsds')->whereIn('id_domaine', $domaine_group)->where('REJETSD', '=', 0)->whereNull('deleted_at')->get();
                $rows =       DB::table('rhsds')->whereIn('id_domaine', $domaine_group)->count();
            }
        }
        if($year != null){
            $perDomaine = $perDomaine->where('ANNEESD', $year);
            $rows = $perDomaine->count();
        }
        if(isset($perDomaine)){
            $rows =       $perDomaine->count();
            $state_o =      $perDomaine->where('ETATSD', '=', 0)->count();
            $state_one =    $perDomaine->where('ETATSD', '=', 1)->count();
            $state_two =    $perDomaine->where('ETATSD', '=', 2)->count();
            $state_three =  $perDomaine->where('ETATSD', '=', 3)->count();
            $state_four =   $perDomaine->where('ETATSD', '=', 4)->count();
            $state_five =   $perDomaine->where('ETATSD', '=', 5)->count();
            $state_six =    $perDomaine->where('ETATSD', '=', 6)->count();
            $goal_done =    $perDomaine->where('ETATSD', '=', 6)->where('ECARTSD', '>=', 0)->count();
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
                $state_four= DB::table('rhsds')->where('ETATSD', '=', 4)->count();
                return $state_four;
                break;
            case 'dcd':
                $state_five= DB::table('rhsds')->where('ETATSD', '=', 5)->count();
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
    public function get_domaineGroupByReg(Request $request){
        $region = $request->region_id;
        $provinces = Dpci::select('id', 'domaine_'.LaravelLocalization::getCurrentLocale().' as name', 'type as t', 'type as ty')->where('dr_id', $region)->get();
        return response()->json(['provinces' => $provinces]);
    }
    public function getUserRole(){  
        $uss = User::where('email',Auth::user()->email)->where('id',Auth::id())->first();
        $userRole = $uss->roles->pluck('name')->first();
        return $userRole;
    }
    public function getSums($rh_sum){
        $sumR = [];
        $sumO = [];
        
        foreach($rh_sum as $rh_year){
            $tempR = 0;
            $tempO = 0;
            foreach($rh_year as $rh){
                $tempR += $rh->REALISATIONSD;
                $tempO += $rh->OBJECTIFSD;
            }
            array_push($sumR, $tempR);
            array_push($sumO, $tempO);
        }
        $sum = [$sumR, $sumO];

        return $sum;
    }
    public function getBadgeRefresh(Request $request){
        $userRole = Auth::user()->roles->pluck('name')->first();
        $rhsds = (new RhsdController)->get_count($userRole, 1);
        $request->session()->put('rh_count', $rhsds);
    }
    public function getEstimate(){
        // have fun
    }
}
