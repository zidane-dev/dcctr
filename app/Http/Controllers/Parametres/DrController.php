<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use App\Models\Dr;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Parametres\DrRequest;

class DrController extends Controller
{

    public $class = 'regions';
    public function __construct(){
        $this->middleware(['permission:administrate'])->only(['index', 'create', 'store']);
        $this->middleware(['permission:edit-baseone'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-baseone'])->only('destroy');
    }

    public function index()
    {
        $class = $this->class;
        $data = Dr::select('id','region_'.LaravelLocalization::getCurrentLocale().' as name')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.1.baseone.index', compact('data', 'class'));
    }

    public function create()
    {
        return view('parametres.1.drs.create');
    }

    public function store(DrRequest $request)
    { 
        $data = $request->only(['region_fr','region_ar']);
        Dr::create([
            'region_fr' => $data['region_fr'],
            'region_ar' => $data['region_ar']
        ]);
        Session::flash('success',__('drs.region success in add'));
        return redirect()->route('regions.index');
    }

    public function edit($id)
    {
        $dr = Dr::find($id);
        if(!$dr){
            return redirect()->back();
        }
        return view('parametres.1.drs.edit',compact('dr'));
    }

    public function update(DrRequest $request, Dr $region)
    {
        $region->update(['region_fr'=>$request->region_fr,
                    'region_ar'=>$request->region_ar]);
        Session::flash('success',__('drs.region success in edit'));
        return redirect()->route('regions.index');
    }

    public function destroy(Request $request)
    {
        $u = Dr::find($request->id);
        $u->delete();
        Session::flash('success',__('drs.region success in supprimer'));
        return redirect()->route('regions.index');
    }
}