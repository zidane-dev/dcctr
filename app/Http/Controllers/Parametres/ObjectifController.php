<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Objectif;
use App\Models\Secteur;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Parametres\ObjectifRequest;

class ObjectifController extends Controller
{

    public $class = 'objectifs';
    public function __construct()
    {
        $this->middleware(['permission:access-objectifs']);
        $this->middleware(['permission:list-objectifs'])->only('index');
        $this->middleware(['permission:create-objectifs'])->only(['create', 'store']);
        $this->middleware(['permission:edit-objectifs'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-objectifs'])->only('destroy');
    }
    public function index()
    {
        $datas = Objectif::with(['secteur' => function($q){
            $q->select('id', 'secteur_'.LaravelLocalization::getCurrentLocale().' as secteur');
        }])->select('id', 'objectif_'.LaravelLocalization::getCurrentLocale().' as name', 'secteur_id')
                                    ->orderBy('id', 'ASC')
                                    ->get();
        // return view('parametres.2.objectifs.index', compact('datas', 'class'));
        return view('parametres.2.objectifs.index', (['datas' => $datas, 'class' => $this->class]));
    }

    public function create()
    {
        $secteurs = Secteur::select('id', 'secteur_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        return view('parametres.2.objectifs.create', compact('secteurs'));
    }

    public function store(ObjectifRequest $request)
    {
        $data = $request->only(['objectif_fr', 'objectif_ar', 'secteur_id']);
        Objectif::create([
            'objectif_fr' => $data['objectif_fr'] ,
            'objectif_ar' => $data['objectif_ar'] ,
            'secteur_id' => $data['secteur_id']
        ]);
        return redirect()->route('objectifs.index');
    }

    public function edit(Objectif $objectif)
    {
        $secteurs = Secteur::select('id', 'secteur_'.LaravelLocalization::getCurrentLocale().' as name')->cursor();
        return view('parametres.2.objectifs.edit', compact('objectif', 'secteurs'));
    }

    public function update(ObjectifRequest $request, Objectif $objectif)
    {
        $data = $request->only(['objectif_fr', 'objectif_ar', 'secteur_id']);
        $objectif->update([
            'objectif_fr' => $data['objectif_fr'],
            'objectif_ar' => $data['objectif_ar'],
            'secteur_id' => $data['secteur_id']
        ]);
        Session::flash('success',__('objectifs.objectif success in edit'));
        return redirect()->route('objectifs.index');
    }

    public function destroy(Request $request)
    {
        $attr = Objectif::find($request->id);

        //UNATTACH SECTEUR ?

        Objectif::destroy($attr->id);

        Session::flash('success',__('objectifs.objectif success in supprimer'));
        return redirect()->back();
    }
}
