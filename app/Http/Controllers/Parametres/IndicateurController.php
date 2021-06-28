<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use App\Models\Indicateur;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;
use App\Http\Requests\Parametres\IndicateurRequest;

class IndicateurController extends Controller
{
    public $class = "indicateurs";
    public function __construct()
    {
        $this->middleware(['permission:access-indicateurs']);
        $this->middleware(['permission:list-indicateurs'])->only('index');
        $this->middleware(['permission:create-indicateurs'])->only(['create', 'store']);
        $this->middleware(['permission:edit-indicateurs'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-indicateurs'])->only('destroy');
    }
    public function index()
    {
        $data = Indicateur::select('id','indicateur_'.LaravelLocalization::getCurrentLocale().' as name')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.indicateurs.index', ['data' => $data, 'class' => $this->class]);
    }

    public function create()
    {
        return view('parametres.1.indicateurs.create', ['class' => $this->class]);
    }

    public function store(IndicateurRequest $request)
    { 
        $data = $request->only(['champ_fr','champ_ar']);

        Indicateur::create([
            'indicateur_fr' => $data['champ_fr'],
            'indicateur_ar' => $data['champ_ar']
        ]);

        Session::flash('success',__('indicateurs.indicateur success in add'));
        return redirect()->route('indicateurs.index');
    }

    public function edit($id)
    {
        $indicateur = Indicateur::find($id);
        if(!$indicateur){
            return redirect()->back();
            //message ?
            //how could it happen ?
        }
        $data = (object) ['id' => $indicateur->id, 'data_fr' => $indicateur->indicateur_fr, 'data_ar' => $indicateur->indicateur_ar];
        return view('parametres.1.indicateurs.edit', ['data' => $data, 'class' => $this->class]);
    }

    public function update(IndicateurRequest $request, Indicateur $indicateur)
    {
        $indicateur->update(['indicateur_fr'=>$request->champ_fr,
                        'indicateur_ar'=>$request->champ_ar]);
        Session::flash('success',__('indicateurs.indicateur success in edit'));
        return redirect()->route('indicateurs.index');
    }

    public function destroy(Request $request)
    {
        $u = Indicateur::find($request->id);
        $u->delete();
        Session::flash('success',__('indicateurs.indicateur success in supprimer'));
        return redirect()->back();
    }
}
