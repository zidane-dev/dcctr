<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use App\Models\Secteur;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Parametres\SecteurRequest;

class SecteurController extends Controller
{
    public $class = "secteurs";
    public function __construct(){
        $this->middleware(['permission:administrate'])->only(['index', 'create', 'store']);
        $this->middleware(['permission:edit-baseone'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-baseone'])->only('destroy');
    }
    public function index()
    {
        $class = $this->class;
        $data = Secteur::select('id','secteur_'.LaravelLocalization::getCurrentLocale().' as name')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.baseone.index', compact('data', 'class'));
    }

    public function create()
    {
        $class = $this->class;
        return view('parametres.1.secteurs.create', compact('class'));
    }

    public function store(SecteurRequest $request)
    { 
        $data = $request->only(['champ_fr','champ_ar']);

        secteur::create([
            'secteur_fr' => $data['champ_fr'],
            'secteur_ar' => $data['champ_ar']
        ]);

        Session::flash('success',__('secteurs.secteur success in add'));
        return redirect()->route('secteurs.index');
    }

    public function edit($id)
    {
        $secteur = Secteur::find($id);
        if(!$secteur){
            return redirect()->back();
            //message ?
            //how could it happen ?
        }
        $class = $this->class;
        $data = (object) ['id' => $secteur->id, 'data_fr' => $secteur->secteur_fr, 'data_ar' => $secteur->secteur_ar ];
        return view('parametres.1.secteurs.edit',compact('data', 'class'));
    }

    public function update(SecteurRequest $request, Secteur $secteur)
    {
        $secteur->update(['secteur_fr'=>$request->champ_fr,
                        'secteur_ar'=>$request->champ_ar]);

        Session::flash('success',__('secteurs.secteur success in edit'));
        return redirect()->route('secteurs.index');
    }

    public function destroy(Request $request)
    {
        $u = Secteur::find($request->id);
        $u->delete();
        Session::flash('success',__('secteurs.secteur success in supprimer'));
        return redirect()->back();
    }
}
