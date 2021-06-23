<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Validation\AxeValidationController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Parametres\AxeController;
use App\Models\Dpci;
use App\Models\Qualite;
use App\User;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RhValidationController extends Controller
{
    public function __construct()
    {
        $this->table = 'rhsds';
        $this->helper = (new AxeValidationController($this->table));   
    }
    
    public function index(){
        $class = $this->table;
        $query = $this->helper->get_query();
        $query = $query->select('rhsds.id','OBJECTIF','REALISATION','ANNEE', 'ETAT', 'REJET','id_qualite','id_domaine','id_user','Description','Motif', 'username', 'updated_at as date', 'qualite', 'domaine', 'type', 't', 'ty');
        
        $qualites = Qualite::select('qualites.id','qualite_'.LaravelLocalization::getCurrentLocale().' as qualite');
        $dpcis = Dpci::select('dpcis.id','domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t', 'type as ty');
        $users = User::select('users.id','name as username');
        $datas = $query->leftJoinSub($qualites, 'qualites', function($join) {
                            $join->on('rhsds.id_qualite', '=', 'qualites.id');});
        $datas = $this->helper->domaine_n_user($datas)
                                ->orderBy('date', 'DESC')
                                ->get();

        $rows_count = $this->helper->get_states_overview();
        $rows_count = $this->helper->get_goals($rows_count);
        $axe = (new AxeController)->get_axe(3);
        return view('validations.rhs', compact('datas', 'rows_count', 'axe', 'class'));
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

    public function get_frame(){
        
    }
    
}
