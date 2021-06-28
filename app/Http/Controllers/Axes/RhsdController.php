<?php

namespace App\Http\Controllers\Axes;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Rhsd;
use App\Models\Qualite;
use App\Models\Dpci;
use App\Models\Axe;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\MetabaseController;
use App\Http\Controllers\Validation\UserValidationController;
use Exception;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Throwable;

class RhsdController extends Controller
{
    private $helper;
    private $table;

    public function __construct(){
        $this->middleware(['permission:administrate|ac|sd|dc']);
        $this->middleware(['permission:add-basethree|add-on'])->only(['create', 'store']);
        $this->middleware(['permission:edit-basethree'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-basethree'])->only('destroy');

        $this->helper = new AxeHelperController();
        $this->table = 'rhsds';
    }
    public function index(Request $request){
        $table = $this->table;         
        try{
            $data = $this->helper->index($table, $request);
            if($data['gate'] == 1){
                return view('parametres.3.rhsds.index',with( ['data_v'   => $data['data_v'], 
                                                                'years'    => $data['years'],  
                                                                'filters'  => $data['filters'],
                                                                'frame'    => $data['frame'], 
                                                                'table'    => $table  
                                                            ]));
            }else{
                return view('parametres.3.rhsds.index',with( [  'count'    => $data['count'],
                                                                'years'    => $data['years'], 
                                                                'dp'       => $data['dp'],
                                                                'frame'    => $data['frame'],
                                                                'data_v'   => $data['data_v'],
                                                                'table'    => $table  
                                                            ]));
            }

        } catch(Throwable $e){
            Session::flash('error',__('parametre.error_loading_data').'  ERROR:'.$e);
            return redirect()->back();
        }
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
            
            $public = (new UserValidationController)->get_supposed_states('public');
            $validated_rhs = Rhsd::where('ETAT', $public)
                                ->where('id_domaine', '=', $request->domaine)
                                ->where('id_qualite', '=', $request->qualite)
                                ->where('ANNEE', '=', $year);

            if($validated_rhs->count() > 0){
                $validated_rh = $validated_rhs->first();
                if($validated_rh->OBJECTIF != $request->objectif){
                    Session::flash('error',__('rhsd.different_obj_exists')." ".__('rhsd.supprimez_ligne'));
                    return redirect()->back();
                }
            }
            
            $ecart = $request->realisation - $request->objectif;
            Rhsd::create([
                'id_qualite' => $request->qualite,
                'id_domaine' => $request->domaine,
                'id_axe' => $request->axe,
                'ANNEE' => $year,
                'OBJECTIF' => $request->objectif,
                'REALISATION' => $request->realisation,
                'ECART' => $ecart,
                'ETAT' => 0,
                'REJET' => 0,
                'id_user' => Auth::id(),
            ]);

            Session::flash('success',__('rhsd.success_add'));
            (new BadgeController)->refresh_badges($request);

            return redirect()->back();
        }
    }
    public function show($id){
        $rh_selected =  Rhsd::where('id', '=', $id)->first();
        $rh = Rhsd::select('id','OBJECTIF','REALISATION','ANNEE', 'ETAT','REJET','id_qualite','id_domaine','id_user','Description','Motif', 'updated_at as date');
        $uss = User::where('id', Auth::id())->first();
        $userRole = $uss->roles->pluck('name')->first();
        
        $rh = $rh->where('id_domaine', '=', $rh_selected->id_domaine)
                ->where('ANNEE', '=', $rh_selected->ANNEE)
                ->where('id_qualite', '=', $rh_selected->id_qualite);

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

        $rejet = [];
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
            $fullDate = now()->format('Y-m-d');

        ////////////////////////////////////////////////////////////////////
        if($flag == 1){
            unset($rhsd->REALISATION);
        }
        ////////////////////////////////////////////////////////////////////
        if($rhsd->REJET == 1){
            $user = User::where('id', $rhsd->id_user)->select('name')->first();
            $rejet = ['user'=>$user];
        }
        return view('parametres.3.rhsds.edit', compact('rhsd', 'qualites', 'domaines', 'axes', 'fullDate', 'rejet'));
    }
    public function update(Request $request, $id){
        $rhsd = Rhsd::find($id);
        $ecart = $this->helper->get_ecart($request->realisation, $request->objectif);
        $rhsd->update([
            'id_qualite' => $request->qualite,
            'ANNEE' => $request->ANNEE,
            'OBJECTIF' => $request->objectif,
            'REALISATION' => $request->realisation,
            'ECART' => $ecart,
            'id_user' => Auth::id(),
            'ETAT' => 0,
            'REJET' => 0,
            'Motif' => '',
            'Description' => '',
            'updated_at' => now()
        ]);
        (new BadgeController)->refresh_badges($request);
        Session::flash('success',__('rhsd.success_edit'));
    
        return redirect()->route('validation.rhsds');
    }
    public function destroy(Request $request){
        $rhsd = Rhsd::find($request->rhsd_id);
        $rhsd->delete();
        Session::flash('success', __('rhsd.success_supprimer'));
        return redirect()->route('rhs.index');
    } 
    public function get_query($domaine=null, $year=null){ //for INDEX
        $public = (new UserValidationController)->get_supposed_states('public');
        $query = Rhsd::select('id',
                                'OBJECTIF',
                                'REALISATION',
                                'ANNEE',
                                'ECART',
                                'ETAT',
                                'id_qualite',
                                'id_domaine',
                                'id_axe',
                                'updated_at as date')
                                ->whereIn('ETAT', $public)
                                ->where('REJET', 0);

        $query = $query->with(
            ['qualite' => function($q){
                $q->select('id','qualite_'.LaravelLocalization::getCurrentLocale().' as qualite');
            }])->with(
            ['domaine' => function($d){
                $d->select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t', 'type as ty');
            }])->with(
            ['axe' => function($a){
                $a->select('id','axe_'.LaravelLocalization::getCurrentLocale().' as axe');
            }]);
        
        if($domaine != null)
            $query = $query->whereIn('id_domaine', $domaine);
        if($year != null)
            $query = $query->where('ANNEE', $year);
       
        $rhsds = $query->orderBy('id_domaine', 'ASC')
                        ->orderBy('ANNEE', 'ASC')
                        ->get();
        return $rhsds;
    }
    public function add_on($id){
        $data       = $this->edit($id, 1);
        return view('parametres.3.rhsds.newreal')->with(['rhsd' => $data['rhsd'],
                                                         'qualites' => $data['qualites'],
                                                         'domaines' => $data['domaines'],
                                                         'axes' => $data['axes'],
                                                         'fullDate' => $data['fullDate']
                                                        ]);
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
    public function update_goal(Request $request){
        $rh = Rhsd::where('id', '=', $request->id)->first();
        
        $ecart = $this->helper->get_ecart($rh->REALISATION , $request->newObjectif);
        Rhsd::where('id_domaine', '=', $rh->id_domaine)
            ->where('id_qualite', '=', $rh->id_qualite)
            ->where('ANNEE', '=', $rh->ANNEE)
            ->update([  'OBJECTIF' => $request->newObjectif, 
                        'ECART' => $ecart]);

        return redirect()->route('rhs.show', $request->id);
    }
    public function get_select_token($builder, $signer, $secret){
        $token = ($builder)
            ->set('resource', [ 'dashboard' => 2 ])
            ->set('params', ['param' => ''])
            ->sign($signer, $secret)
            ->getToken();

        return $token;
    }
    public function get_region_token($builder, $signer, $secret, $region_id){
        $etat = (new UserValidationController)->get_supposed_states('public');
        $token = ($builder)
            ->set('resource', [ 'dashboard' => 129 ])
            ->set('params', ['region' => $region_id, 'etat' => $etat[0]])
            ->sign($signer, $secret)
            ->getToken();

        return $token;
    }
    public function get_province_token($builder, $signer, $secret, $domaine){
        $etat = (new UserValidationController)->get_supposed_states('public');
        $token = ($builder)
            ->set('resource', [ 'dashboard' => 34 ])
            ->set('params', ['domaine' => $domaine, 'etat' => $etat[0]])
            ->sign($signer, $secret)
            ->getToken();

        return $token;
    }   
}