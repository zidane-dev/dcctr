<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Structure extends Model
{
    use SoftDeletes;

    protected $fillable = ['structure_fr', 'structure_ar'];

    public function domaines(){
        return $this->hasMany('App\Model\Dpci', 'structure_id');
    }
}