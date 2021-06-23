<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Dpci extends Model
{

    use SoftDeletes;
    protected $fillable = ['domaine_fr', 'domaine_ar', 'type', 'dr_id', 'structure_id'];

    public function structure(){
        return $this->belongsTo('App\Models\Structure', 'structure_id');
    }
        
    public function region(){
        return $this->belongsTo('App\Models\Dr', 'dr_id');
    }

    public function users(){
        return $this->hasMany('App\User', 'domaine_id');
    }

    public function rhsds(){
        return $this->hasMany('App\Models\Rhsd','id_domaine');
    }

    public function attprocs(){
        return $this->hasMany('App\Models\AttProc','id_domaine');
    }

    public function getTypeAttribute($val){
        
        if(LaravelLocalization::getCurrentLocale() === 'fr'){
            switch ($val) {
                case 'P' : return "Direction Provinciale"; break;
                case 'R' : return "Direction Régionale"; break;
                case 'C' : return "Direction Centrale"; break;
                // case 'C' : return "Direction Centrale"; break;
                // case 'D' : return "Direction de Coordination"; break;
            }
        }elseif(LaravelLocalization::getCurrentLocale() === 'ar'){
            switch ($val) {
                case 'P' : return "Moudiria Provinciale"; break;
                case 'R' : return "Moudiria Régionale"; break;
                case 'C' : return "Moudiria Centrale"; break;
            }
        }
    }
    public function getTAttribute($val){
        switch ($val) {
            case 'P' : return "DP"; break;
            case 'R' : return "DR"; break;
            case 'C' : return "DC"; break;
            // case 'C' : return "AC"; break;
            // case 'D' : return "DC"; break;
        }
    }

    public function getTyAttribute($val){
        if(LaravelLocalization::getCurrentLocale() === 'fr'){
            switch ($val) {
                case 'P' : return "DP"; break;
                case 'R' : return "DR"; break;
                case 'C' : return "DC"; break;
            }
        }elseif(LaravelLocalization::getCurrentLocale() === 'ar'){
            switch ($val) {
                case 'P' : return "MP"; break;
                case 'R' : return "MR"; break;
                case 'C' : return "MC"; break;
            }
        }
    }
}
