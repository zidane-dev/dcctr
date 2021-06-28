<?php

namespace App\Models;

use App\Models\BaseModels\BaseThree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rhsd extends BaseThree
{
    use SoftDeletes;

    protected $fillable = ['OBJECTIF', 'REALISATION', 'ANNEE', 'ECART', 'ETAT', 'REJET', 'id_qualite','id_domaine','id_axe','id_user','Description','Motif'];

    
    public function qualite(){
        return $this->belongsTo('App\Models\Qualite', 'id_qualite');
    }
    
    public function domaine(){
        return $this->belongsTo('App\Models\Dpci', 'id_domaine');
    }
    
    public function axe(){
        return $this->belongsTo('App\Models\Axe', 'id_axe');
    }

    public function user(){
        return $this->belongsTo('App\User', 'id_user');
    }
}




