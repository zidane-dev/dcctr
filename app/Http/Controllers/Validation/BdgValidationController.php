<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\AxeController;
use App\Http\Controllers\Controller;
use App\Models\Depense;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BdgValidationController extends Controller
{
    public function __construct()
    {
        $this->table = 'budgets';
        $this->helper = (new AxeValidationController($this->table));   
    }
    
    public function index(){
        $class = $this->table;
        $query = $this->helper->get_query();
        $query = $query->select('budgets.id',
                                'OBJECTIF',
                                'REALISATION',
                                'ANNEE',
                                'ETAT',
                                'REJET',
                                'Description',
                                'Motif',
                                'username',
                                'updated_at as date',
                                'depense',
                                'domaine',
                                'type',
                                't',
                                'ty');
        
        $depenses = Depense::select('depenses.id','depense_'.LaravelLocalization::getCurrentLocale().' as depense');
        
        $datas = $query->leftJoinSub($depenses, 'depenses', function($join) {
                            $join->on('budgets.id_depense', '=', 'depenses.id');});
        $datas = $this->helper->domaine_n_user($datas)->get();

        $rows_count = $this->helper->get_states_overview();
        $rows_count = $this->helper->get_goals($rows_count);
        $axe = (new AxeController)->get_axe(4);
        return view('validations.bdg', compact('datas', 'rows_count', 'axe', 'class'));
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
