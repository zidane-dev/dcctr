<?php

namespace App\Models;

use App\Models\BaseModels\BaseOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dr extends BaseOne
{
    use SoftDeletes;
    protected $fillable = ['region_fr', 'region_ar'];

    public function provinces(){
        return $this->hasMany('App\Models\Dpci', 'dr_id');
    }

}
