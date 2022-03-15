@extends('layouts.app')
<?php
//    dd($reviews);
?>

@section('title', '商品レビュー管理')
@section('content')
    <header class="header">
        <div class="header-left">
            <h2 style="height: 60px; line-height: 60px;">商品レビュー管理</h2>
        </div>
        <div class="header-right">
            <ul>
                <?php if(!empty(session('login_date'))): ?>
                <li><a class="btn btn-header" href="{{ route('products.registForm') }}">新規商品登録</a></li>
                <?php endif ?>
            </ul>
        </div>
    </header>
    <main>
{{--        <div class="container bg-color_white">--}}


{{--        </div>--}}

        <div style="margin: 20px"></div>
        <div class="container" style="border: none; width: 700px; box-sizing: border-box; padding: 0">
            @foreach($reviews as $review)
                <div class="product-card" style="min-height: 280px">
                    <div class="product-card-left">
                        <img src="{{ !empty($review->product->image_1) ? "/uploads/".$review->product->image_1: '' }}" alt="">
                    </div>
                    <div class="product-card-right">
                        <div class="category-area">
                            <p style="background-color: #fff; display: inline; padding: 0 10px">
                                {{ \App\Product::showProductCategoryName($review->product->product_category_id) }} > {{ \App\Product::showProductSubCategoryName($review->product->product_subcategory_id) }}
                            </p>
                        </div>
                        <div class="name-area">
                            {{ $review->product->name }}
                        </div>
                        <div class="review-show-area">
                            <div style="margin-top: 10px">
                                @if($review->evaluation == 0))
                                <i class="far fa-star"></i>
                                @elseif($review->evaluation == 1)
                                    <i class="fas fa-star"></i>
                                @elseif(($review->evaluation == 2))
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                @elseif(($review->evaluation == 3))
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                @elseif(($review->evaluation == 4))
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                @elseif(($review->evaluation == 5))
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                @endif
                                {{ $review->evaluation }}
                            </div>
                            <div style="margin-top: 10px">
                                @if(mb_strlen($review->comment) >= 16)
                                    {{ mb_substr($review->comment,0,16) }}...
                                @else
                                    {{ $review->comment }}
                                @endif
                            </div>
                        </div>
                        <div class="form-group btn-wrapper">
                            <a class="btn btn-back" style="border: 1px solid #406bca; background-color: #406bca;color: #fff" href="{{ route('products.revieweditshow', ['review_id' => $review->id]) }}" >レビュー編集</a>
                            <a class="btn btn-back" style="border: 1px solid #406bca; background-color: #406bca;color: #fff" href="{{ route('products.revieweditdeleteshow', ['review_id' => $review->id]) }}" >レビュー削除</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

{{--        @if(!empty($return_product_category_id) || !empty($return_product_subcategory_id) || !empty($freeword))--}}
{{--            <div class="pagination">--}}
{{--                {{ $products->appends(['product_category_id' => $return_product_category_id,'product_subcategory_id' => $return_product_subcategory_id,'freeword' => $return_freeword])->links() }}--}}
{{--            </div>--}}
{{--        @else--}}
            <div class="pagination">
                {{ $reviews->links() }}
            </div>
{{--        @endif--}}


        <div class="form-group btn-wrapper">
            <a class="btn btn-back-blue" href="{{ route('members.mypage') }}">マイページへ</a>
        </div>
    </main>
    <script>
        $(function() {
            $('form').submit(function () {
                $(this).find(':submit').prop('disabled', 'true');
            });
        })
    </script>
@endsection


