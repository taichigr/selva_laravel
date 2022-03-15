@extends('layouts.app')
<?php
//dd(session()->all());

?>

@if(!empty($edit_flg))
    @section('title', '商品レビュー編集')
@else
    @section('title', '商品レビュー登録')
@endif
@section('content')

    <header class="admin-header">
        <div class="header-left">

        </div>
        <div class="header-right">

            <ul>

                {{--            <li><a class="btn btn-header" href="">商品一覧</a></li>--}}
                <?php if(empty(session('admin_login_date'))): ?>
                <li style="border: solid 1px #000"><a class="btn btn-admin-header" href="">ログイン</a></li>
                <?php endif ?>

                <?php if(!empty(session('admin_login_date'))): ?>
                <form method="post" action="">
                    @csrf
                    <li><button style="background-color: #cfcfcf; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>
                </form>
                <?php endif ?>
            </ul>
        </div>
    </header>


    <main class="admin-main">
        <div class="container admin-container">


            @if(!empty($edit_flg))
                <h2>商品レビュー編集</h2>

                    @csrf
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
                        @if (!empty($err_msg))
                            <div class="card-text text-left alert alert-danger">
                                <ul class="mb-0">
                                    <li>{{ $err_msg }}</li>
                                </ul>
                            </div>
                            <?php $err_msg = '';?>
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
                        <form method="POST" action="{{ route('admin.productrevieweditconfirm') }}">
                            @csrf
                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                            <div class="form-group">
                                <div class="form-inline" style="width: 150px;">ID</div>
                                <span style="margin-left: 40px">{{ $review->id }}</span>
                            </div>
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
                                            @if(!empty($review))
                                            <option value="1" {{ $review->evaluation == '1'? 'selected':'' }}>1</option>
                                            <option value="2" {{ $review->evaluation == '2'? 'selected':'' }}>2</option>
                                            <option value="3" {{ $review->evaluation == '3'? 'selected':'' }}>3</option>
                                            <option value="4" {{ $review->evaluation == '4'? 'selected':'' }}>4</option>
                                            <option value="5" {{ $review->evaluation == '5'? 'selected':'' }}>5</option>
                                            @else
                                                レビューがありません。
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="form-inline" style="width: 150px;">商品コメント</div>
                                <div class="form-inline" style="width: 500px;">
                                    @if(!empty(old('comment')))
                                        <textarea name="comment" id="" style="width: 400px; height: 200px">{{ old($comment) }}</textarea>
                                    @else
                                        <textarea name="comment" id="" style="width: 400px; height: 200px">{{ $review->comment }}</textarea>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group btn-wrapper">
                                <input type="submit" class="btn btn-default-blue" value="商品レビュー編集確認">
                            </div>
                            <div class="form-group btn-wrapper">
                                <button class="btn btn-back-blue" type="button" onclick="history.back()">商品レビュー一覧へ戻る</button>
{{--                                <a class="btn btn-back-blue" href="{{ route('admin.productreviewshow') }}">レビュー管理へ戻る</a>--}}
                            </div>

                        </form>

                    </div>
            @else


                <h2>商品レビュー登録</h2>


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
                            <img src="{{ !empty($product->image_1) ? "/uploads/".$product->image_1: '' }}" alt="">
                        </div>
                        <div class="product-card-right">
                            <div class="category-area">
                                <p style="background-color: #fff; display: inline; padding: 0 10px">
                                    {{ \App\Product::showProductCategoryName($product->product_category_id) }} > {{ \App\Product::showProductSubCategoryName($product->product_subcategory_id) }}
                                </p>
                            </div>
                            <div class="name-area">
                                {{ $product->name }}
                            </div>
                            <div class="review-show-area">
                                <div style="margin-top: 10px">
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
                    </div>


                    <div class="review-input-area">
                        <form method="POST" action="{{ route('admin.productreviewregisterconfirm') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="form-group">
                                <div class="form-inline" style="width: 150px;">ID</div>
                                <span style="margin-left: 80px">登録後に自動採番</span>
                            </div>
                            <div class="form-group" style="display: flex;">
                                <div class="form-inline" style="width: 150px;">商品評価</div>
                                <div class="form-inline" style="width: 300px;">
                                    <select style="width: 100px" name="evaluation">
                                            <option value="1" {{ old('evaluation') == '1'? 'selected':'' }}>1</option>
                                            <option value="2" {{ old('evaluation') == '2'? 'selected':'' }}>2</option>
                                            <option value="3" {{ old('evaluation') == '3'? 'selected':'' }}>3</option>
                                            <option value="4" {{ old('evaluation') == '4'? 'selected':'' }}>4</option>
                                            <option value="5" {{ old('evaluation') == '5'? 'selected':'' }}>5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="display: flex;">
                                <div class="form-inline" style="width: 150px;">商品コメント</div>
                                <div class="form-inline" style="width: 500px;">
                                        <textarea name="comment" id="" style="width: 400px; height: 200px">{{ old($comment) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group btn-wrapper">
                                <input type="submit" class="btn btn-default-blue" value="確認画面へ">
                            </div>
                            <div class="form-group btn-wrapper">
                                <button class="btn btn-back-blue" type="button" onclick="history.back()">商品レビュー一覧へ戻る</button>
                            </div>

                        </form>

                    </div>

{{--                    <div class="form-group btn-wrapper">--}}
{{--                        <input class="btn btn-back-blue" type="submit" value="確認画面へ">--}}
{{--                    </div>--}}
            @endif

        </div>
    </main>
@endsection
