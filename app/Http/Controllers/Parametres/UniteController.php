<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use App\Models\Unite;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Requests\Parametres\UniteRequest;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class UniteController extends Controller
{
    
    public $class = "unites";

    public function __construct()
    {
     
    }

    public function index()
    {
        $data = Unite::select('id','unite_'.LaravelLocalization::getCurrentLocale().' as name')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.unites.index', [ 'data' => $data, 'class'=>'unites']);
    }

    public function create()
    {
        return view('parametres.1.unites.create', ['class' => $this->class]);
    }

    public function store(UniteRequest $request)
    { 
        $data = $request->only(['champ_fr','champ_ar']);

        Unite::create([
            'unite_fr' => $data['champ_fr'],
            'unite_ar' => $data['champ_ar']
        ]);

        Session::flash('success',__('unites.unite success in add'));
        return redirect()->route('unites.index');
    }

    public function edit($id)
    {
        $unite = Unite::find($id);
        if(!$unite){
            return redirect()->back();
            //message ?
            //how could it happen ?
        }
        $data = (object) ['id' => $unite->id, 'data_fr' => $unite->unite_fr, 'data_ar' => $unite->unite_ar ];
       
        return view('parametres.1.unites.edit',['class' => $this->class ,'data' => $data]);
    }

    public function update(UniteRequest $request, Unite $unite)
    {
        $unite->update(['unite_fr'=>$request->champ_fr,
                        'unite_ar'=>$request->champ_ar]);
        Session::flash('success',__('unites.unite success in edit'));
        return redirect()->route('unites.index');
    }

    public function destroy(Request $request)
    {
        $u = Unite::find($request->id);
        $u->delete();
        Session::flash('success',__('unites.unite success in supprimer'));
        return redirect()->back();
    }
}