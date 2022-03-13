@extends('layouts.app')
<?php
//    dd($reviews);
?>

@section('title', '商品レビュー編集確認')
@section('content')
    <header class="header">
        <div class="header-left">
            <h2 style="height: 60px; line-height: 60px;">商品レビュー編集確認</h2>
        </div>
        <div class="header-right">
            <ul>
                <?php if(!empty(session('login_date'))): ?>
                <li><a class="btn btn-header" href="{{ route('index') }}">トップに戻る</a></li>
                <?php endif ?>
            </ul>
        </div>
    </header>
    <main>



        <div style="margin: 20px"></div>
        <div class="container" style="border: none; width: 700px; box-sizing: border-box; padding: 0">

            <div class="product-card" style="border-top: none">
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
                    </div>
                </div>
            </div>


            <div class="review-input-area">
{{--                編集を更新--}}
                <form method="POST" action="{{ route('products.revieweditcomplete') }}">
                    @csrf
                    <input type="hidden" name="review_id" value="{{ $review->id }}">
                    <input type="hidden" name="evaluation" value="{{ $evaluation }}">
                    <input type="hidden" name="comment" value="{{ $comment }}">

                    <div class="form-group" style="display: flex;">
                        <div class="form-inline" style="width: 150px;">商品評価</div>
                        <div class="form-inline" style="width: 300px;">
                            {{ $evaluation }}
                        </div>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <div class="form-inline" style="width: 150px;">商品コメント</div>
                        <div class="form-inline" style="width: 500px;">

                                <div>{!! nl2br(e($comment)) !!}</div>

                        </div>
                    </div>
                    <div class="form-group btn-wrapper">
                        <input type="submit" class="btn btn-default-blue" value="更新する">
                    </div>
                    <div class="form-group btn-wrapper">
                        <button type="button" class="btn btn-back-blue" onClick="history.back()">前に戻る</button>
                    </div>

                </form>

            </div>

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


