<?php

namespace App\Models;

use App\Models\BaseModels\BaseOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Axe extends BaseOne
{
    use SoftDeletes;
    protected $fillable = ['axe_fr', 'axe_ar'];

    public function rhsds(){
        return $this->hasMany('App\Models\Rhsd', 'id_axe');
    }

    public function attprocs(){
        return $this->hasMany('App\Models\AttProc', 'id_axe');
    }
}
