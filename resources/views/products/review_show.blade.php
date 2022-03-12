@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
// レビュー登録
//    dd('この処理');
//    dd($reviews);
//    受け取っているのは$review, $average

//    dd($reviews);
?>

@section('title', '商品レビュー一覧')
@section('content')
    <header class="header">
        <div class="header-left">
            <h2 style="height: 60px; line-height: 60px;">商品レビュー一覧</h2>
        </div>
        <div class="header-right">
            <ul>
                <li><a class="btn btn-header" href="{{ route('index') }}">トップに戻る</a></li>
            </ul>
        </div>
    </header>
    <main>
        <div style="margin: 20px"></div>
        <div class="container" style="width: 900px; border: none; box-sizing: border-box; padding: 20px">

            <div class="review-product-data-area">
                <div class="review-image-wrapper">
                    <img src="{{ !empty($product->image_1) ? "/uploads/".$product->image_1: '' }}" alt="">
                </div>

                <div class="form-group" style="padding-top: 20px">
                    <div>
                        <h2 style="text-align: left">{{ $product->name }}</h2>
                    </div>
                    <div style="margin-top: 10px">
                        総合評価　
                        {{--                    塗りつぶし用 <i class="fas fa-star"></i>--}}
                        {{--                    空欄用 <i class="far fa-star"></i>--}}
                        {{--                    半分 <i class="fas fa-star-half-alt"></i>--}}


                        @if(!empty($average))
                            @if((ceil($average) == 0))
                                <i class="far fa-star"></i>
                            @elseif(ceil($average) == 1)
                                <i class="fas fa-star"></i>
                            @elseif((ceil($average) == 2))
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            @elseif((ceil($average) == 3))
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            @elseif((ceil($average) == 4))
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            @elseif((ceil($average) == 5))
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            @endif
                            {{ ceil($average) }}
                        @else
                            レビュー無し
                        @endif
                    </div>
                </div>
            </div>

            <div class="review-show-area">
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="form-group" style="display: flex">
                            <div class="form-inline" style="width: 150px; font-weight: bold">{{ $review->member->name_sei.$review->member->name_mei }}</div>
                            <div class="form-inline" style="width: 500px">
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
                        <div class="form-group" style="display: flex">
                            <div class="form-inline" style="width: 150px; font-weight: bold">商品コメント</div>
                            <div class="form-inline" style="width: 500px">{!! nl2br(e($review->comment)) !!}</div>

                        </div>
                    </div>
                @endforeach
                <div class="pagination">
                    {{ $reviews->appends(['product_id' => $product->id])->links() }}

                </div>

            </div>





                <div style="text-align: center">
                    <div class="inline">
{{--                        <div class="btn-wrapper-detail">--}}
{{--                            <a class="btn btn-back-blue" href="{{ route('products.reviewregist', ['id' => $product->id]) }}" >この商品についてのレビューを登録</a>--}}
{{--                        </div>--}}
                        <div class="btn-wrapper-detail">
                            <a class="btn btn-back-blue" href="{{ route('products.detail', ['id' => $product->id]) }}" >商品詳細に戻る</a>
                        </div>
                    </div>
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


