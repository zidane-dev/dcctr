<?php

namespace App\Models;

use App\Models\BaseModels\BaseOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeCredit extends BaseOne
{
    use SoftDeletes;
    protected $fillable = ['type_credit_fr','type_credit_ar'];
}
