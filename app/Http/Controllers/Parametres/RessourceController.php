<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parametres\RessourceRequest;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RessourceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:access-unites']);
    //     $this->middleware(['permission:list-unites'])->only('index');
    //     $this->middleware(['permission:create-unites'])->only(['create', 'store']);
    //     $this->middleware(['permission:edit-unites'])->only(['edit', 'update']);
    //     $this->middleware(['permission:delete-unites'])->only('destroy');
    // }

    public $class = "ressources";
    public function index()
    {
        $data = Ressource::select('id','ressource_'.LaravelLocalization::getCurrentLocale().' as name')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.ressources.index', ['data' => $data, 'class' => $this->class]);
    }

    public function create()
    {
        return view('parametres.1.ressources.create', ['class' => $this->class]);
    }

    public function store(RessourceRequest $request)
    {
        $data = $request->only(['champ_fr','champ_ar']);

        Ressource::create([
            'ressource_fr' => $data['champ_fr'],
            'ressource_ar' => $data['champ_ar']
        ]);

        Session::flash('success',__('ressources.success in add'));
        return redirect()->route('ressources.index');
    }

    public function edit($id)
    {
        $ressource = Ressource::find($id);
        if(!$ressource){
            return redirect()->back();
            //message ?
            //how could it happen ?
        }
        $data = (object) ['id' => $ressource->id, 'data_fr' => $ressource->ressource_fr, 'data_ar' => $ressource->ressource_ar ];
       
        return view('parametres.1.ressources.edit', ['class' => $this->class, 'data' => $data ]);
    }

    public function update(RessourceRequest $request, Ressource $ressource)
    {
        $ressource->update(['ressource_fr'=>$request->champ_fr,
                        'ressource_ar'=>$request->champ_ar]);
        Session::flash('success',__('ressources.success in edit'));
        return redirect()->route('ressources.index');
    }

    public function destroy(Request $request)
    {
        $u = Ressource::find($request->id);
        $u->delete();
        Session::flash('success',__('ressources.success in supprimer'));
        return redirect()->back();
    }
}
