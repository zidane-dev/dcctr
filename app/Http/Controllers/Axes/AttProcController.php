<?php

namespace App\Http\Controllers\Axes;

use App\Http\Controllers\Controller;
use App\Models\AttProc;
use App\Models\Dpci;
use App\Models\Dr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Axes\AxeHelperController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\Validation\UserValidationController;
use App\Models\Action;
use App\Models\Secteur;
use Exception;
use Illuminate\Support\Facades\Session;

class AttProcController extends Controller
{

    private $helper;
    private $table;

    public function __construct(){
        $this->middleware(['permission:administrate|ac|sd|dc']);
        $this->middleware(['permission:add-basethree|add-on'])->only(['create', 'store']);
        $this->middleware(['permission:edit-basethree'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-basethree'])->only('destroy');

        $this->helper = new AxeHelperController();
        $this->table = 'att_procs';
    }
    public function index(Request $request){
        $table = $this->table;         
        try{
            $data = $this->helper->index($table, $request);
            $attributions = $data['data_v']->where('id_axe', 1);
            $delegations = $data['data_v']->where('id_axe', 2);
            $att_deleg = [$attributions, $delegations];
            if($data['gate'] == 1){
                return view('parametres.3.attprocs.index',with(['data_v'   => $att_deleg, 
                                                                'years'    => $data['years'],  
                                                                'filters'  => $data['filters'],
                                                                'frame'    => $data['frame'], 
                                                                'table'    => $table  
                                                            ]));
            }else{
                
                return view('parametres.3.attprocs.index',with(['count'    => $data['count'],
                                                                'years'    => $data['years'], 
                                                                'dp'       => $data['dp'],
                                                                'frame'    => $data['frame'],
                                                                'data_v'   => $att_deleg,
                                                                'table'    => $table  
                                                            ]));
            }

        } catch(Exception $e){
            Session::flash('error',__('parametre.error_loading_data').'  ERROR:'.$e);
            return redirect()->back();
        }
    }
    public function get_query($domaine=null, $year=null){ //for INDEX
        $public = (new UserValidationController)->get_supposed_states('public');
        $data = AttProc::select('id',
                                'STATUT',
                                'ANNEE',
                                'ETAT',
                                'id_attribution',
                                'id_action',
                                'id_domaine',
                                'id_level',
                                'id_axe',
                                'updated_at as date')
                                ->whereIn('ETAT', $public)
                                ->where('REJET', 0);

        $data = $data->with(
            ['attribution' => function($q){
                $q->select('id','attribution_'.LaravelLocalization::getCurrentLocale().' as attribution');
            }])->with(
            ['action' => function($q){
                $q->select('id','action_'.LaravelLocalization::getCurrentLocale().' as action');
            }])->with(
            ['niveau' => function($q){
                $q->select('id','name_'.LaravelLocalization::getCurrentLocale().' as niveau');
            }])->with(
            ['domaine' => function($d){
                $d->select('id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t', 'type as ty');
            }])->with(
            ['axe' => function($a){
                $a->select('id','axe_'.LaravelLocalization::getCurrentLocale().' as axe');
            }]);
        
        if($domaine != null){
            $data = $data->whereIn('id_domaine', $domaine);
        }
        if($year != null){
            $data = $data->where('ANNEE', $year);
        }
            
        $data = $data->orderBy('id_domaine', 'ASC')
                        ->orderBy('ANNEE', 'ASC')
                        ->get();
        return $data;
    }

    public function create()
    {
        $secteurs = Secteur::all();
        $attribution = $secteurs->first()->attribution->first();
        $actions = Action::all();
        return view('parametres.3.attprocs.create', compact('secteurs', 'actions'));
    }
    public function store(Request $request)
    {
        // if($request->total_domaines == domaines[].length ) // useless
        // dd($request->input());
        
        switch($request->type){
            case 'T' :
                $axe = 1;
                break;
            case 'D' :
                $axe = 2;
            default:
                throw new Exception('type transfert error');
        }
        $annee = $request->date_creation;
        $niveau = $this->niveau_byTypeMaturite($request->type_domaine, $request->maturite);
        $attribution = $request->attribution;
        $domaines_id = $request->domaine;
        $action = $request->action;

        foreach($domaines_id as $domaine){
            AttProc::create([
                'id_axe'    => $axe,
                'id_domaine'=> $domaine,
                'id_attribution'=>$attribution,
                'id_action' => $action,
                'id_level'  => $niveau,
                'ANNEE'     => $annee,
                'ANNEERLS'  => NULL,
                'STATUT'    => 1,
                'ETAT'      => 0,           // need a validation for this
                'REJET'     => 0,
                'id_user'   => Auth::id(),
            ]);
        }

        Session::flash('succes', __('att_procs.stored'));
        (new BadgeController)->refresh_badges($request);

        return redirect()->route('validation.att_procs');
    }  
  
    public function store_recap(Request $request){
        $niveau = $this->niveau_byTypeMaturite($request->domaine, $request->maturite);
        $domaines = Dpci::where('type', $request->domaine)->where('level_id', $niveau)->get();
        $locale = LaravelLocalization::getCurrentLocale();
        return response()->json([
            'domaine_list'      => $domaines,
            'locale'            => $locale
        ]);
    }
    public function niveau_byTypeMaturite($type_domaine, $maturite){
        switch($maturite){
            case 'M':
                $niveau = 1;
                break;
            case 'D':
                $niveau = 3;
                break;
            case 'E':
                $niveau = 5;
                break;
            default:
                throw new Exception();
        }
        if($type_domaine == 'P'){
            $niveau += 1;
        }
        return $niveau;
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id){
        //
    }
    public function destroy($id){
        //
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
        $token = ($builder)
            ->set('resource', [ 'dashboard' => 33 ])
            ->set('params', ['region' => [$region_id]])
            ->sign($signer, $secret)
            ->getToken();

        return $token;
    }
    public function get_province_token($builder, $signer, $secret, $domaine){
        
        $token = ($builder)
            ->set('resource', [ 'dashboard' => 34 ])
            ->set('params', ['domaine' => $domaine])
            ->sign($signer, $secret)
            ->getToken();

        return $token;
    }
}
