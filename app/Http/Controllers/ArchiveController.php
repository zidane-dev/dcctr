<?php

namespace App\Http\Controllers;

use App\Models\Rhsd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rhsds = Rhsd::onlyTrashed();
        $rhsds = $rhsds->with(['qualite' => function($q){
            $q->select('id', 'qualite_'.LaravelLocalization::getCurrentLocale().' as qualite');
        }])->with(['axe' => function($a){
            $a->select('id', 'axe_'.LaravelLocalization::getCurrentLocale().' as axe');
        }])->with(['domaine'=>function($d){
            $d->select('id', 'domaine_'.LaravelLocalization::getCurrentLocale().' as domaine', 'type', 'type as t');
        }])->get();
        $table_name ="z";
        return view('archives.param_arch', compact('rhsds', 'table_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
