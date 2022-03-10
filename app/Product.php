<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'product_category_id',
        'product_subcategory_id',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'product_content',
    ];
}
