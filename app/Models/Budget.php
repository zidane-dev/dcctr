<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use SoftDeletes;

    protected $fillable = ['OBJECTIF_BDG', 'REALISATION_BDG', 'ANNEE_BDG', 'ECART', 'ETAT', 'REJET', 'id_depense','id_domaine','id_axe','id_user','Description','Motif'];

    public function domaine(){
        return $this->belongsTo('App\Models\Dpci', 'id_domaine');
    }
    
    public function axe(){
        return $this->belongsTo('App\Models\Axe', 'id_axe');
    }

    public function user(){
        return $this->belongsTo('App\User', 'id_user');
    }

    public function depense(){
        return $this->belongsTo('App\Models\Depense', 'id_depense');
    }

    
}
