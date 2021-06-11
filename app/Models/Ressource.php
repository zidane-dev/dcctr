<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ressource extends Model
{
    use SoftDeletes;
    protected $fillable = ['ressource_fr', 'ressource_ar'];
    
    public function depenses(){
        return $this->hasMany('App\Models\Depense', 'id_ressource');
    }
}
