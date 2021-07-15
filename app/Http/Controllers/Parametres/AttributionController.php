<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use App\Models\Attribution;
use App\Models\Secteur;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Requests\Parametres\AttributionRequest;
use Illuminate\Support\Facades\Session;

class AttributionController extends Controller
{
    public $class = "attributions";

    public function __construct(){
        $this->middleware(['permission:administrate'])->only(['index', 'create', 'store']);
        $this->middleware(['permission:edit-baseone'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-baseone'])->only('destroy');
    }
    public function index()
    {
        $class = $this->class;
        $datas = Attribution::with(['secteur' => function($q){
            $q->select('id', 'secteur_'.LaravelLocalization::getCurrentLocale().' as secteur');
        }])->select('id', 'attribution_'.LaravelLocalization::getCurrentLocale().' as name', 'secteur_id')
                                    ->orderBy('id', 'ASC')
                                    ->get();
        return view('parametres.2.attributions.index', compact('datas', 'class'));
    }

    public function create()
    {
        $secteurs = Secteur::select('id', 'secteur_'.LaravelLocalization::getCurrentLocale().' as name')->get();
        return view('parametres.2.attributions.create', compact('secteurs'));
    }

    public function store(AttributionRequest $request)
    {
        $data = $request->only(['attribution_fr', 'attribution_ar', 'secteur_id']);
        Attribution::create([
            'attribution_fr' => $data['attribution_fr'] ,
            'attribution_ar' => $data['attribution_ar'] ,
            'secteur_id' => $data['secteur_id']
        ]);
        return redirect()->route('attributions.index');
    }

    public function edit(Attribution $attribution)
    {
        $secteurs = Secteur::select('id', 'secteur_'.LaravelLocalization::getCurrentLocale().' as name')->cursor();
        return view('parametres.2.attributions.edit', compact('attribution', 'secteurs'));
    }

    public function update(AttributionRequest $request, Attribution $attribution)
    {
        $data = $request->only(['attribution_fr', 'attribution_ar', 'secteur_id']);
        $attribution->update([
            'attribution_fr' => $data['attribution_fr'],
            'attribution_ar' => $data['attribution_ar'],
            'secteur_id' => $data['secteur_id']
        ]);
        Session::flash('success',__('attributions.attribution success in edit'));
        return redirect()->route('attributions.index');
    }

    public function destroy(Request $request)
    {
        $attr = Attribution::find($request->id);

        //UNATTACH SECTEUR ?

        Attribution::destroy($attr->id);

        Session::flash('success',__('attributions.attribution success in supprimer'));
        return redirect()->back();
    }
}
