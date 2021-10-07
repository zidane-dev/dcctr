<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = ['filename', 'id_user', 'titre_fr', 'titre_ar'];


    public function user(){
        return $this->belongsTo('App\User', 'id_user');
    }


}

