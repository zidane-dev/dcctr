<?php

namespace App\Http\Controllers;

use App\Models\Rhsd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $table_name ="z";
        return view('archives.param_arch', compact('rhsds', 'table_name'));
    }

    public function get_table_name($case){
        switch($case){
            case '' :
                break;
            case '' :
                break;
            default:
        }
    }

    public function get_table(){

    }


    public function destroy($id)
    {
        dd($id);
    }
}
