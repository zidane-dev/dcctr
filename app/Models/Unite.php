<?php

namespace App\Models;

use App\Models\BaseModels\BaseOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unite extends BaseOne
{
    use SoftDeletes;
    protected $fillable = ['unite_fr', 'unite_ar'];
}
