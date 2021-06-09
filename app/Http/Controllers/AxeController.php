<?php

namespace App\Http\Controllers;

use App\Models\Axe;
use Illuminate\Http\Request;
use App\Http\Requests\Parametres\AxeRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;

class AxeController extends Controller
{
    public $class = "axes";

    public function __construct()
    {
        $this->middleware(['permission:access-axes']);
        $this->middleware(['permission:list-axes'])->only('index');
        $this->middleware(['permission:create-axes'])->only(['create', 'store']);
        $this->middleware(['permission:edit-axes'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-axes'])->only('destroy');
    }

    public function index()
    {
        $data = Axe::select('id','axe_'.LaravelLocalization::getCurrentLocale().' as name')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.axes.index', ['data' => $data, 'class' => $this->class]);
    }

    public function create()
    {
        return view('parametres.1.axes.create', ['class' => $this->class]);
    }

    public function store(AxeRequest $request)
    { 
        $data = $request->only(['champ_fr','champ_ar']);

        Axe::create([
            'axe_fr' => $data['champ_fr'],
            'axe_ar' => $data['champ_ar']
        ]);

        Session::flash('success',__('axes.axe success in add'));
        return redirect()->route('axes.index');
    }

    public function edit($id)
    {
        $axe = Axe::find($id);
        if(!$axe){
            return redirect()->back();
            //message ?
            //how could it happen ?
        }
        $data = (object) ['id' => $axe->id, 'data_fr' => $axe->axe_fr, 'data_ar' => $axe->axe_ar ];
       
        return view('parametres.1.axes.edit', ['class' => $this->class, 'data' => $data ]);
    }

    public function update(AxeRequest $request, Axe $axe)
    {
        $axe->update(['axe_fr'=>$request->champ_fr,
                        'axe_ar'=>$request->champ_ar]);
        Session::flash('success',__('axes.axe success in edit'));
        return redirect()->route('axes.index');
    }

    public function destroy(Request $request)
    {
        $u = Axe::find($request->id);
        $u->delete();
        Session::flash('success',__('axes.axe success in supprimer'));
        return redirect()->back();
    }
}
