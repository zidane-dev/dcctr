<?php

namespace App\Http\Controllers\Axes;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MetabaseController;
use App\Http\Controllers\User\DomaineController;
use App\Http\Controllers\User\SessionController;
use App\Http\Controllers\User\UsebdgelperController;
use App\Http\Controllers\Validation\UserValidationController;
use App\Models\Budget;
use App\Models\Dpci;
use App\Models\Dr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BudgetController extends Controller
{
    private $helper;
    private $table;

    public function __construct(){
        $this->middleware(['permission:administrate|ac|sd|dc']);
        $this->middleware(['permission:add-basethree|add-on'])->only(['create', 'store']);
        $this->middleware(['permission:edit-basethree'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-basethree'])->only('destroy');

        $this->helper = new AxeHelperController();
        $this->table = 'budgets';
    }
    public function index(Request $request){
        $table = $this->table;         
        try{
            $data = $this->helper->index($table, $request);
            if($data['gate'] == 1){
                return view('parametres.3.budgets.index',with( ['data_v'   => $data['data_v'], 
                                                                'years'    => $data['years'],  
                                                                'filters'  => $data['filters'],
                                                                'frame'    => $data['frame'], 
                                                                'table'    => $table  
                                                            ]));
            }else{
                return view('parametres.3.budgets.index',with( ['achieved' => $data['achieved'],
                                                                'years'    => $data['years'], 
                                                                'dp'       => $data['dp'],
                                                                'frame'    => $data['frame'],
                                                                'data_v'   => $data['data_v'],
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
        $query = Budget::select('id',
                                'OBJECTIF',
                                'REALISATION',
                                'ANNEE',
                                'ECART',
                                'ETAT',
                                'id_depense',
                                'id_domaine',
                                'id_axe',
                                'updated_at as date')
                                ->whereIn('ETAT', $public)
                                ->where('REJET', 0);

        $query = $query->with(
            ['depense' => function($q){
                $q->select('id','depense_'.LaravelLocalization::getCurrentLocale().' as depense');
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
       
        $datas = $query->orderBy('id_domaine', 'ASC')
                        ->orderBy('ANNEE', 'ASC')
                        ->get();
        return $datas;
    }
    public function create(){
        //
    }
    public function store(Request $request){
        //
    }
    public function show($id){
        //
    }
    public function edit($id){
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