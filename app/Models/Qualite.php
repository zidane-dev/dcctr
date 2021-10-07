<?php

namespace App\Models;

use App\Models\BaseModels\BaseOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qualite extends BaseOne
{
    use SoftDeletes;

    protected $fillable = ['qualite_fr', 'qualite_ar'];
    
    public function rhsds(){
        return $this->hasMany('App\Models\Rhsd', 'id_qualite');
    }
}
