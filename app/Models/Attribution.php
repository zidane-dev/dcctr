<?php

namespace App\Models;

use App\Models\BaseModels\BaseTwo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribution extends BaseTwo
{
    use SoftDeletes;
    protected $fillable = ['attribution_fr', 'attribution_ar', 'secteur_id'];

    public function secteur(){
        return $this->belongsTo('App\Models\Secteur', 'secteur_id');
    }

    public function attprocs(){
        return $this->hasMany('App\Models\AttProc', 'id_attribution');
    }
}
