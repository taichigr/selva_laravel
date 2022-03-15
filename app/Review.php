<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    //
//    static function averageEvaluation($product_id)
//    {
//        $this::where('product_id', $product_id)->get('evaluation')->avg();
//    }
    use SoftDeletes;


    public function member(): BelongsTo
    {
        return $this->belongsTo('App\Member');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Product');
    }
}
