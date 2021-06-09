<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Parametres\StructureRequest;

class StructureController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:access-structures']);
        $this->middleware(['permission:list-structures'])->only('index');
        $this->middleware(['permission:create-structures'])->only(['create', 'store']);
        $this->middleware(['permission:edit-structures'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-structures'])->only('destroy');
    }
    public function index()
    {
        $structures = Structure::select('id','structure')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.structures.index', compact('structures'));
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
