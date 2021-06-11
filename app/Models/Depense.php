<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depense extends Model
{
    use SoftDeletes;
    protected $fillable = ['id_ressource','depense_fr', 'depense_ar'];

    public function ressource(){
        return $this->belongsTo('App\Models\Ressource', 'id_ressource');
    }
}
