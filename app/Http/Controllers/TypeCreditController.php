<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeCredit;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Requests\Parametres\TypeCreditRequest;

class TypeCreditController extends Controller
{
    public function index()
    {
        $type_credits = TypeCredit::select('id','type_credit_'.LaravelLocalization::getCurrentLocale().' as type_credit')
                        ->orderBy('id','ASC')
                        ->cursor();
        return view('parametres.type_credits.index', compact('type_credits'));
    }

    public function create()
    {
        return view('parametres.1.type_credits.create');
    }

    public function store(TypeCreditRequest $request)
    { 
        $data = $request->only(['type_credit_fr','type_credit_ar']);

        TypeCredit::create([
            'type_credit_fr' => $data['type_credit_fr'],
            'type_credit_ar' => $data['type_credit_ar']
        ]);

        Session::flash('success',__('type_credits.type_credit success in add'));
        return redirect()->route('typecredits.index');
    }

    public function edit($id)
    {
        $type_credit = TypeCredit::find($id);
        if(!$type_credit){
            return redirect()->back();
            //message ?
            //how could it happen ?
        }
        return view('parametres.1.type_credits.edit',compact('type_credit'));
    }

    public function update(TypeCreditRequest $request, TypeCredit $type_credit)
    {
        $type_credit->update(['type_credit_fr'=>$request->type_credit_fr,
                        'type_credit_ar'=>$request->type_credit_ar]);
        Session::flash('success',__('type_credits.type_credit success in edit'));
        return redirect()->route('typecredits.index');
    }

    public function destroy(Request $request)
    {
        $u = TypeCredit::find($request->id);
        $u->delete();
        Session::flash('success',__('type_credits.type_credit success in supprimer'));
        return redirect()->back();
    }
}
