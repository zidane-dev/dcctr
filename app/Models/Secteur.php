<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Secteur extends Model
{
    use SoftDeletes;
    protected $fillable = ['secteur_fr', 'secteur_ar'];

    public function attribution(){
        return $this->hasMany('App\Models\Attribution', 'secteur_id');
    }

    public function objectif(){
        return $this->hasMany('App\Models\Objectif', 'secteur_id');
    }
}
