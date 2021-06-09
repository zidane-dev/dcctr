<?php

namespace App\Models;

use App\Models\BaseModels\BaseTwo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objectif extends BaseTwo
{
    use SoftDeletes;
    protected $fillable = ['objectif_fr', 'objectif_ar', 'secteur_id'];

    public function secteur(){
        return $this->belongsTo('App\Models\Secteur', 'secteur_id');
    }
}
