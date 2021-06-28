<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttProc extends Model
{
    use SoftDeletes;
    protected $fillable = ['id_axe',
                            'id_attribution',
                            'id_action',
                            'id_level',
                            'ANNEE',
                            'ANNEERLS',
                            'STATUT',
                            'ETAT',
                            'REJET',
                            'id_user'];

    public function axe(){
        return $this->belongsTo('App\Models\Axe',  'id_axe');
    }

    public function user(){
        return $this->belongsTo('App\User', 'id_user');
    }

    public function attribution(){
        return $this->belongsTo('App\Models\Attribution', 'id_attribution');
    }
    
    public function niveau(){
        return $this->belongsTo('App\Models\Level', 'id_level');
    }

    public function domaine(){
        return $this->belongsTo('App\Models\Dpci', 'id_domaine');
    }

    public function action(){
        return $this->belongsTo('App\Models\Action', 'id_action');
    }
}
