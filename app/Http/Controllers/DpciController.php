<?php

namespace App\Http\Controllers;

use App\Models\Dpci;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Dr as DR;
use Illuminate\Support\Facades\DB;

class DpciController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:access-unites']);
        $this->middleware(['permission:list-unites'])->only('index');
        $this->middleware(['permission:create-unites'])->only(['create', 'store']);
        $this->middleware(['permission:edit-unites'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-unites'])->only('destroy');
    }

    public $class = "dpcis";

    public function index()
    {
        $levels = DB::table('levels')->select('id', 'name')->get();

        $datas = Dpci::with(['region' => function($q){
            $q->select('id','region_'.LaravelLocalization::getCurrentLocale().' as region');
        }])->select('dpcis.id','domaine_'.LaravelLocalization::getCurrentLocale().' as name','type','dr_id')
            ->leftJoin("levels", 'levels.id', '=', 'dpcis.level_id')->addselect('levels.name as lvl')
            ->orderBy('dpcis.id','ASC')->get();
        return view('parametres.2.dpcis.index', (['datas' => $datas]));
    }

    
    public function create()
    {
        $regions = DR::select('id','region_'.LaravelLocalization::getCurrentLocale().' as region')->cursor();
        $levels = DB::table('levels')->select('id', 'name')->get();

        return view('parametres.2.dpcis.create',compact('regions', 'levels'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['champ_fr','champ_ar','region','type']);

        Dpci::create([
            'domaine_fr' => $data['champ_fr'],
            'domaine_ar' => $data['champ_ar'],
            'type' => $data['type'],
            'dr_id' => $data['region']
        ]);
        Session::flash('success',__('dpci.Province success in add'));
        return redirect()->back();
    }

    public function edit(Dpci $dpci)
    {
        if(!$dpci){
            return redirect()->back();
        }
        $regions = DR::select('id','region_'.LaravelLocalization::getCurrentLocale().' as name')->cursor();
        return view('parametres.2.dpcis.edit',compact('dpci','regions'));
    }

    public function update(Request $request, Dpci $dpci)
    {
        $data = $request->only(['champ_fr', 'champ_ar', 'region', 'type']);
        $dpci->update([
            'domaine_fr' => $data['champ_fr'],
            'domaine_ar' => $data['champ_ar'],
            'type' => $data['type'],
            'dr_id' => $data['region']
        ]);
        Session::flash('success',__('attributions.attribution success in edit'));
        return redirect()->route('dpcis.index');
    }

    public function destroy(Request $request)
    {
        $u = Dpci::find($request->id);
        $u->delete();
        Session::flash('success',__('dpci.Province success in supprimer'));
        return redirect()->back();
    }
}
