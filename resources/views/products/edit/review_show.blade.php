@extends('layouts.app')
<?php
//    dd($reviews);
//    dd(old('evaluation'));
?>

@section('title', '商品レビュー編集')
@section('content')
    <header class="header">
        <div class="header-left">
            <h2 style="height: 60px; line-height: 60px;">商品レビュー編集</h2>
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
            <div class="err-msg">
                @if ($errors->any())
                    <div class="card-text text-left alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
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
                <form method="POST" action="{{ route('products.revieweditconfirm') }}">
                    @csrf
                    <input type="hidden" name="review_id" value="{{ $review->id }}">
                    <div class="form-group" style="display: flex;">
                        <div class="form-inline" style="width: 150px;">商品評価</div>
                        <div class="form-inline" style="width: 300px;">
                            <select style="width: 100px" name="evaluation">
                                @if(!empty(old('evaluation')))
                                <option value="1" {{ old('evaluation') == '1'? 'selected':'' }}>1</option>
                                <option value="2" {{ old('evaluation') == '2'? 'selected':'' }}>2</option>
                                <option value="3" {{ old('evaluation') == '3'? 'selected':'' }}>3</option>
                                <option value="4" {{ old('evaluation') == '4'? 'selected':'' }}>4</option>
                                <option value="5" {{ old('evaluation') == '5'? 'selected':'' }}>5</option>
                                @else
                                    <option value="1" {{ $review->evaluation == '1'? 'selected':'' }}>1</option>
                                    <option value="2" {{ $review->evaluation == '2'? 'selected':'' }}>2</option>
                                    <option value="3" {{ $review->evaluation == '3'? 'selected':'' }}>3</option>
                                    <option value="4" {{ $review->evaluation == '4'? 'selected':'' }}>4</option>
                                    <option value="5" {{ $review->evaluation == '5'? 'selected':'' }}>5</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="display: flex;">
                        <div class="form-inline" style="width: 150px;">商品コメント</div>
                        <div class="form-inline" style="width: 500px;">
                            @if(!empty(old('comment')))
                            <textarea name="comment" id="" style="width: 400px; height: 200px">{!! nl2br(e(old('comment'))) !!}</textarea>
                            @else
                                <textarea name="comment" id="" style="width: 400px; height: 200px">{!! nl2br(e($review->comment)) !!}</textarea>
                            @endif
                        </div>
                    </div>
                    <div class="form-group btn-wrapper">
                        <input type="submit" class="btn btn-default-blue" value="商品レビュー編集確認">
                    </div>
                    <div class="form-group btn-wrapper">
                        <a class="btn btn-back-blue" href="{{ route('products.revieweditmanagement') }}">レビュー管理へ戻る</a>
                    </div>

                </form>

            </div>

        </div>




    </main>
    <script>
        // $(function() {
        //     $('form').submit(function () {
        //         $(this).find(':submit').prop('disabled', 'true');
        //     });
        // })
    </script>
@endsection


