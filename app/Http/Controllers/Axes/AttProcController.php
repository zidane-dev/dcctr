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
use App\Http\Controllers\Validation\UserValidationController;
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
        dd($secteurs->first()->attribution->first()->attribution_fr, $secteurs->first()->attribution->first()->secteur->secteur_fr);
    }
    public function store(Request $request)
    {
        
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
