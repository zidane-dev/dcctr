<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Structure;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Parametres\StructureRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StructureController extends Controller
{
    //Doesn't support arabic yet. 
    // (did add the migration field.)

    public $class = 'structures';
    public function __construct(){
        $this->middleware(['permission:administrate'])->only(['index', 'create', 'store']);
        $this->middleware(['permission:edit-baseone'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-baseone'])->only('destroy');
    }
    public function index()
    {
        $class = $this->class;
        $data = Structure::select('id','structure_'.LaravelLocalization::getCurrentLocale().' as name')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.baseone.index', compact('data', 'class'));
    }

    public function create()
    {
        return view('parametres.1.structures.create');
    }

    public function store(StructureRequest $request)
    { 
        $data = $request->only(['structure_fr']);

        Structure::create([
            'structure' => $data['structure_fr']
        ]);

        Session::flash('success',__('structures.structure success in add'));
        return redirect()->route('structures.index');
    }

    public function edit($id)
    {
        $structure = Structure::find($id);
        if(!$structure){
            return redirect()->back();
            //message ?
            //how could it happen ?
        }
        return view('parametres.1.structures.edit',compact('structure'));
    }

    public function update(StructureRequest $request, Structure $structure)
    {
        $structure->update(['structure'=>$request->structure_fr]);

        Session::flash('success',__('structures.structure success in edit'));
        return redirect()->route('structures.index');
    }

    public function destroy(Request $request)
    {
        $u = Structure::find($request->id);
        $u->delete();
        Session::flash('success',__('structures.structure success in supprimer'));
        return redirect()->back();
    }
}
