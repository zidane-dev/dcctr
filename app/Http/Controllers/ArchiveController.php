<?php

namespace App\Http\Controllers;

use App\IndicPerforms;
use App\Models\AttProc;
use App\Models\Budget;
use App\Models\Rhsd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ArchiveController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $rhsds = Rhsd::onlyTrashed();
        $rhsds = $rhsds->with(['qualite' => function($q){
            $q->select('id', 'qualite_'.LaravelLocalization::getCurrentLocale().' as qualite');
        }])->with(['axe' => function($a){
            $a->select('id', 'axe_'.LaravelLocalization::getCurrentLocale().' as axe');
        }])->with(['domaine'=>function($d){
            $d->select('id', 'domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t');
        }])->get();
        $table_name ="rhsds";
        return view('archives.param_arch', compact('rhsds', 'table_name'));
    }

    public function load_rh(){
        $datas = Rhsd::onlyTrashed()->get();
        return View::make('partials.table_rhs', compact('datas'));
    }
    public function load_bg(){
        $datas = Budget::onlyTrashed()->get();
        return View::make('partials.table_bdg', compact('datas'));
    }
    public function load_at(){
        $datas = AttProc::onlyTrashed()->get();
        return View::make('partials.table_atts', compact('datas'));
    }
    public function load_ip(){
        return View::make('partials.table_idp');
    }

    public function get_table_name($case){
        switch($case){
            case 'attprocs' :
                return AttProc::onlyTrashed();
                break;
            case 'rhsds' :
                return Rhsd::onlyTrashed();
                break;
            case 'budgets' :
                return Budget::onlyTrashed();
                break;
            case 'indics' :
                return IndicPerforms::onlyTrashed();
                break;
            default:
                return redirect()->back();
        }
    }

    public function get_table(){

    }


    public function destroy($id)
    {
        dd($id);
    }
}
