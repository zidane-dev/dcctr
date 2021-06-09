<?php

namespace App\Models;

use App\Models\BaseModels\BaseOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicateur extends BaseOne
{
    use SoftDeletes;
    protected $fillable = ['indicateur_fr', 'indicateur_ar'];
}
