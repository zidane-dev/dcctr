<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
    use SoftDeletes;
    protected $fillable = ['action_fr', 'action_ar'];

    public function attprocs(){
        return $this->hasMany('App\Model\AttProc', 'id_action');
    }
}
