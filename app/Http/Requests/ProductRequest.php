<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => 'required|string|max:100',
            'product_category_id' => 'required|string',
            'product_subcategory_id' => 'required|string',
            'image_1' => 'max:500',
            'image_2' => 'max:500',
            'image_3' => 'max:500',
            'image_4' => 'max:500',
            'product_content' => 'required|string|max:500',
//
//            'name' => 'required|max:50',
//            'price' => 'required|integer',
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
