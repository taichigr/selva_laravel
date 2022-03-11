<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    //
    public function registForm()
    {
        $product_categories = DB::table('product_categories')->get();
        $product_subcategories = DB::table('product_subcategories')->get();
        return view('products.regist',[
            'product_categories' => $product_categories,
            'product_subcategories' => $product_subcategories
            ]);
    }
    public function getSubCategories(Request $request)
    {

        $product_subcategories = DB::table('product_subcategories')
            ->where('product_category_id', $request->categoryid)
            ->get();
        return [
            'product_subcategories' => $product_subcategories
        ];
    }


    public function productStorecheck(ProductRequest $request, Product $product)
    {
        //
        $product_categories = DB::table('product_categories')->get();
        $product_subcategories = DB::table('product_subcategories')->get();
        //ここの処理では画像のパスを保存
        $product->member_id = session()->get('member_id');
        $product->product_category_id = $request->product_category_id;
        $product->product_subcategory_id = $request->product_subcategory_id;
        $product->name = $request->name;
        $product->image_1 = $request->image_1;
        $product->image_2 = $request->image_2;
        $product->image_3 = $request->image_3;
        $product->image_4 = $request->image_4;
        $product->product_content = $request->product_content;
//        $product->save();
        return view('products.regist_confirm', [
            'product' => $product,
            'product_categories' => $product_categories,
            'product_subcategories' => $product_subcategories
        ]);
        // フォームリクエストでバリデーション
        // 画像を保存して、パスと他のデータをDBに保存
    }

    public function productStore(Request $request, Product $product)
    {
        $product->member_id = session()->get('member_id');
        $product->product_category_id = $request->product_category_id;
        $product->product_subcategory_id = $request->product_subcategory_id;
        $product->name = $request->name;
        $product->image_1 = $request->image_1;
        $product->image_2 = $request->image_2;
        $product->image_3 = $request->image_3;
        $product->image_4 = $request->image_4;
        $product->product_content = $request->product_content;
        $product->save();
        return redirect('/');
    }


    public function registImage(Request $request)
    {
        // 画像アップロード機能
        $this->validate($request, [
            'image_1' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'image_2' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'image_3' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'image_4' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        Log::info('バリデーション後', ['image_1の情報' => $request->all()]);
//        return;
        // バリデーションは通っているのか？そして、データはリクエストのどこに入っているのか
        if ($file1 = $request->image_1) {
            $fileName1 = time() . $file1->getClientOriginalName();
            $target_path1 = public_path('uploads/');
            $file1->move($target_path1, $fileName1);
            return ['returnFileName1' => $fileName1];
        } else {
            $fileName1 = "";
        }
        if ($file2 = $request->image_2) {
            $fileName2 = time() . $file2->getClientOriginalName();
            $target_path2 = public_path('uploads/');
            $file2->move($target_path2, $fileName2);
            return ['returnFileName2' => $fileName2];
        } else {
            $fileName2 = "";
        }
        if ($file3 = $request->image_3) {
            $fileName3 = time() . $file3->getClientOriginalName();
            $target_path3 = public_path('uploads/');
            $file3->move($target_path3, $fileName3);
            return ['returnFileName3' => $fileName3];
        } else {
            $fileName3 = "";
        }
        if ($file4 = $request->image_4) {
            $fileName4 = time() . $file4->getClientOriginalName();
            $target_path4 = public_path('uploads/');
            $file4->move($target_path4, $fileName4);
            return ['returnFileName4' => $fileName4];
        } else {
            $fileName4 = "";
        }
    }

    public function show()
    {
        $products = DB::table('products')->paginate(10);
        $product_categories = DB::table('product_categories')->get();
        $product_subcategories = DB::table('product_subcategories')->get();
        return view('products.show', [
            'products' => $products,
            'product_categories' => $product_categories,
            'product_subcategories' => $product_subcategories,
        ]);
    }

    public function search(Request $request, Product $product)
    {
        $product_categories = DB::table('product_categories')->get();
        $product_subcategories = DB::table('product_subcategories')->get();

        $product_category_id = $request->product_category_id;
        $product_subcategory_id = $request->product_subcategory_id;
        $freeword = $request->freeword;
        if(!empty($product_category_id) && !empty($product_subcategory_id) && !empty($freeword)){
            $products = $product->where([
                'product_category_id' => $product_category_id,
                'product_subcategory_id' => $product_subcategory_id,
            ])->orwhere('name', 'like', '%'.$freeword.'%')
                ->orwhere('product_content', 'like', '%'.$freeword.'%')
                ->paginate(10);
        } elseif(!empty($product_category_id) && empty($product_subcategory_id) && empty($freeword)) {
            $products = $product->where([
                'product_category_id' => $product_category_id,
            ])->paginate(10);
        } elseif (!empty($product_category_id) && !empty($product_subcategory_id) && empty($freeword)) {
            $products = $product->where([
                'product_category_id' => $product_category_id,
                'product_subcategory_id' => $product_subcategory_id,
            ])->paginate(10);
        } elseif (!empty($product_category_id) && empty($product_subcategory_id) && !empty($freeword)) {
            $products = $product->where([
                'product_category_id' => $product_category_id,
            ])->orwhere('name', 'like', '%'.$freeword.'%')
                ->orwhere('product_content', 'like', '%'.$freeword.'%')
                ->paginate(10);
        } elseif (empty($product_category_id) && empty($product_subcategory_id) && !empty($freeword)) {
            $products = $product->orwhere('name', 'like', '%'.$freeword.'%')
                ->orwhere('product_content', 'like', '%'.$freeword.'%')
                ->paginate(10);
        } else {
            return redirect('products.show');
        }
        return view('products.show', [
            'products' => $products,
            'return_product_category_id' => $product_category_id,
            'return_product_subcategory_id' => $product_subcategory_id,
            'return_freeword' => $freeword,
            'product_categories' => $product_categories,
            'product_subcategories' => $product_subcategories,
        ]);
    }
}
