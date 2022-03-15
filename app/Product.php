<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    //

    use SoftDeletes;

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

    static function showProductCategoryName($product_category_id)
    {
        $product_category = DB::table('product_categories')
            ->where('id', $product_category_id)->first();
        $product_category_name = $product_category->name;
        return $product_category_name;
    }
    static function showProductSubCategoryName($product_subcategory_id)
    {
        $product_subcategory = DB::table('product_subcategories')
            ->where('id', $product_subcategory_id)->first();
        $product_subcategory_name = $product_subcategory->name;
        return $product_subcategory_name;
    }
}
