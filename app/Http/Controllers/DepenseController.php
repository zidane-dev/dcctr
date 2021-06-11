<?php

namespace App\Http\Controllers;

use App\Http\Requests\Parametres\DepenseRequest;
use App\Models\Depense;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DepenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:access-depenses']);
        $this->middleware(['permission:list-depenses'])->only('index');
        $this->middleware(['permission:create-depenses'])->only(['create', 'store']);
        $this->middleware(['permission:edit-depenses'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-depenses'])->only('destroy');
    }

    public $class = "depenses";

    public function index()
    {
        $datas = Depense::with(['ressource' => function($q){
            $q->select('id','ressource_'.LaravelLocalization::getCurrentLocale().' as ressource');
        }])->select('id','depense_'.LaravelLocalization::getCurrentLocale().' as name', 'id_ressource')
            ->orderBy('id','ASC')->get();
        return view('parametres.2.depenses.index', (['datas' => $datas, 'class' => $this->class]));
    }

    public function create()
    {
        $ressources = Ressource::select('id', 'ressource_'.LaravelLocalization::getCurrentLocale().' as ressource')->cursor();
        return view('parametres.2.depenses.create',compact('ressources'));
    }

    public function store(DepenseRequest $request)
    {
        $data = $request->only(['champ_fr', 'champ_ar', 'ressource']);

        Depense::create([
            'depense_fr' => $data['champ_fr'],
            'depense_ar' => $data['champ_ar'],
            'id_ressource' => $data['ressource']
        ]);

        Session::flash('success', __('depenses.success in add'));
        return redirect()->back();
    }

    public function edit(Depense $depense)
    {
        if(!$depense){
            return redirect()->back();
        }
        $ressources = Ressource::select('id', 'ressource_'.LaravelLocalization::getCurrentLocale().' as ressource')->cursor();
        return view('parametres.2.depenses.edit',compact('depense','ressources'));
    }

    public function update(DepenseRequest $request, Depense $depense)
    {
        $data = $request->only(['champ_fr', 'champ_ar', 'ressource']);
        $depense->update([
            'depense_fr' => $data['champ_fr'],
            'depense_ar' => $data['champ_ar'],
            'ressource'  => $data['ressource']
        ]);

        Session::flash('success', __('depenses.success in edit'));
        return redirect()->route('depenses.index');
    }

    public function destroy(Request $request)
    {
        $dep = Depense::find($request->id);
        $dep->delete();
        Session::flash('success', __('depenses.success in supprimer'));
        return redirect()->back();
    }
}
