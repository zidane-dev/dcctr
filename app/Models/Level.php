<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;
    protected $fillable = ['name_fr', 'name_ar'];

    protected $table = 'levels';

    public function attprocs(){
        return $this->hasMany('App\Models\AttProc', 'id_level');
    }
    public function dpcis(){
        return $this->hasMany('App\Models\Dpci', 'level_id');
    }
}