<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Parametres\AxeController;
use App\Models\Action;
use App\Models\Attribution;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ADgValidationController extends Controller
{
    public function __construct()
    {
        $this->table = 'att_procs';
        $this->helper = (new AxeValidationController($this->table));   
    }

    public function index(){
        $table = $this->table;
        $query = $this->helper->get_query();
        $query = $query->select('att_procs.id',
                                'ANNEE', 
                                'ETAT', 
                                'REJET',
                                'id_domaine',
                                'STATUT',
                                'username',
                                'updated_at as date',
                                'attribution',
                                'action',
                                'level',
                                'domaine',
                                'type',
                                't',
                                'ty');

        $query =  $query->where('STATUT', 1);

        $attributions = Attribution::select('attributions.id', 'attribution_'.LaravelLocalization::getCurrentLocale().' as attribution');
        $actions = Action::select('actions.id', 'action_'.LaravelLocalization::getCurrentLocale().' as action');
        $levels = Level::select('levels.id', 'name_'.LaravelLocalization::getCurrentLocale().' as level');
        
        $datas = $query->leftJoinSub($attributions, 'attributions', function($join) {
                            $join->on('att_procs.id_attribution', '=', 'attributions.id');})
                        ->leftJoinSub($actions, 'actions', function($join) {
                            $join->on('att_procs.id_action', '=', 'actions.id');})
                        ->leftJoinSub($levels, 'levels', function($join) {
                            $join->on('att_procs.id_level', '=', 'levels.id');});
        $att_deleg = $this->helper->domaine_n_user($datas);

        $data = $att_deleg->orderBy('ANNEE', 'ASC')
                                ->orderBy('attribution', 'ASC')
                                ->orderBy('action', 'ASC')->get();
        
        $axes = [(new AxeController)->get_axe(1), (new AxeController)->get_axe(2)];
        if(Auth::user()->hasPermissionTo('view-etats')){
            return view('validations.atts', compact('data', 'rows_count', 'axes', 'table'));

        }
        $rows_count = $this->helper->get_states_overview();
        return view('validations.atts', compact('data', 'axes', 'table'));
    }


    public function valider(Request $request){
        return $this->helper->valider($request);
    }
    public function rejeter(Request $request){
        return $this->helper->rejeter($request);
    }

    public function getBadgeRefresh($request){
        $badge_count = $this->helper->get_badge_count($request);
        return $badge_count;
    }
}
