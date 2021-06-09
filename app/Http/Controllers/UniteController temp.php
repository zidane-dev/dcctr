<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Requests\Parametres\UniteRequest;
use Illuminate\Support\Facades\Session;

class UniteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:access-unites']);
        $this->middleware(['permission:list-unites'])->only('index');
        $this->middleware(['permission:create-unites'])->only(['create', 'store']);
        $this->middleware(['permission:edit-unites'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-unites'])->only('destroy');
    }
    public function index()
    {
        $unites = Unite::select('id','unite_'.LaravelLocalization::getCurrentLocale().' as unite')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.unites.index', compact('unites'));
    }

    public function create()
    {
        return view('parametres.unites.create');
    }

    public function store(UniteRequest $request)
    { 
        $data = $request->only(['unite_fr','unite_ar']);

        Unite::create([
            'unite_fr' => $data['unite_fr'],
            'unite_ar' => $data['unite_ar']
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
        return view('parametres.unites.edit',compact('unite'));
    }

    public function update(UniteRequest $request, Unite $unite)
    {
        $unite->update(['unite_fr'=>$request->unite_fr,
                        'unite_ar'=>$request->unite_ar]);
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