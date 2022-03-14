<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_subcategory extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
