<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use App\Models\Axe;
use Illuminate\Http\Request;
use App\Http\Requests\Parametres\AxeRequest;
use Exception;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;

class AxeController extends Controller
{
    public $class = "axes";

    public function __construct()
    {
        $this->middleware(['permission:administrate'])->only(['index', 'create', 'store']);
        $this->middleware(['permission:edit-baseone'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-baseone'])->only('destroy');
    }
    
    public function get_axe($table){
        switch($table){
            case 1: // attributions
                $axe = Axe::select('id', 'axe_'.LaravelLocalization::getCurrentLocale().' as axe')->where('id', 1)->first();
                break;
            case 2: // delegations
                $axe = Axe::select('id', 'axe_'.LaravelLocalization::getCurrentLocale().' as axe')->where('id', 2)->first();
                break;
            case 3: // rh
                $axe = Axe::select('id', 'axe_'.LaravelLocalization::getCurrentLocale().' as axe')->where('id', 3)->first();
                break;
            case 4: //rm
                $axe = Axe::select('id', 'axe_'.LaravelLocalization::getCurrentLocale().' as axe')->where('id', 4)->first();
                break;
            case 5: //indics
                $axe = Axe::select('id', 'axe_'.LaravelLocalization::getCurrentLocale().' as axe')->where('id', 5)->first();
                break;
            default: 
                throw new Exception("Couldn't fetch the Axe", 1);
        }
        return $axe;
    }

    public function index()
    {
        $data = Axe::select('id','axe_'.LaravelLocalization::getCurrentLocale().' as name')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.baseone.index', ['data' => $data, 'class' => $this->class]);
    }

    public function create()
    {
        return view('parametres.1.baseone.create', ['class' => $this->class]);
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
       
        return view('parametres.1.baseone.edit', ['class' => $this->class, 'data' => $data ]);
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
