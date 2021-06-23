<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use App\Models\Qualite;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Parametres\QualiteRequest;

class QualiteController extends Controller
{
    public $class = "qualites";
    public function __construct(){
        $this->middleware(['permission:access-qualites']);
        $this->middleware(['permission:list-qualites'])->only('index');
        $this->middleware(['permission:create-qualites'])->only(['create', 'store']);
        $this->middleware(['permission:edit-qualites'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-qualites'])->only('destroy');
    }
    public function index()
    {
        $class = $this->class;
        $data = Qualite::select('id','qualite_'.LaravelLocalization::getCurrentLocale().' as name')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.qualites.index', compact('data', 'class'));
    }

    public function create()
    {
        $class = $this->class;
        return view('parametres.1.qualites.create', 'class');
    }

    public function store(QualiteRequest $request)
    { 
        $data = $request->only(['champ_fr','champ_ar']);

        Qualite::create([
            'qualite_fr' => $data['champ_fr'],
            'qualite_ar' => $data['champ_ar']
        ]);

        Session::flash('success',__('qualites.qualite success in add'));
        return redirect()->route('qualites.index');
    }

    public function edit($id)
    {
        $qualite = Qualite::find($id);
        if(!$qualite){
            return redirect()->back();
            //message ?
            //how could it happen ?
        }
        $class = $this->class;
        $data = (object) ['id' => $qualite->id, 'data_fr' => $qualite->qualite_fr, 'data_ar' => $qualite->qualite_ar ];
        return view('parametres.1.qualites.edit',compact('data', 'class'));
    }

    public function update(QualiteRequest $request, Qualite $qualite)
    {
        $qualite->update(['qualite_fr'=>$request->qualite_fr,
                        'qualite_ar'=>$request->qualite_ar]);
        Session::flash('success',__('qualites.qualite success in edit'));
        return redirect()->route('qualites.index');
    }

    public function destroy(Request $request)
    {
        $u = Qualite::find($request->id);
        $u->delete();
        Session::flash('success',__('qualites.qualite success in supprimer'));
        return redirect()->back();
    }
}
