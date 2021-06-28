<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'domaine_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    ############################################

    public function domaine(){
        return $this->belongsTo('App\Models\Dpci', 'domaine_id');
    }

    public function rhsds(){
        return $this->hasMany('App\Models\Rhsd', 'id_user');
    }
    
    public function attprocs(){
        return $this->hasMany('App\Models\AttProc', 'id_user');
    }

    public function userable()
    {
        return $this->morphTo();
    }
}
