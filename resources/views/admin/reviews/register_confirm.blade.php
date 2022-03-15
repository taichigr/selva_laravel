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
            @else
                <h2>商品レビュー登録</h2>
            @endif


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
                    @if(!empty($edit_flg))
                            <form method="POST" action="{{ route('admin.productrevieweditcomplete') }}">
                        @else
                            <form method="POST" action="{{ route('admin.productreviewregistercomplete') }}">
                        @endif

                        @csrf
                        @if(!empty($edit_flg))
                                    <input type="hidden" name="review_id" value="{{ $review_id }}">
                                @else
                            <input type="hidden" name="product_id" value="{{ $product_id }}">
                            <input type="hidden" name="member_id" value="{{ $member_id }}">
                        @endif
                        <input type="hidden" name="evaluation" value="{{ $evaluation }}">
                        <input type="hidden" name="comment" value="{{ $comment }}">


                                @if(!empty($edit_flg))
                                    <div class="form-group">
                                        <div class="form-inline" style="width: 150px;">ID</div>
                                        <span style="margin-left: 80px">{{ $review_id }}</span>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <div class="form-inline" style="width: 150px;">ID</div>
                                        <span style="margin-left: 80px">登録後に自動採番</span>
                                    </div>
                                @endif

                        <div class="form-group" style="display: flex;">
                            <div class="form-inline" style="width: 150px;">商品評価</div>
                            <div class="form-inline" style="width: 300px;">
                                    <span>{{ $evaluation }}</span>
                            </div>
                        </div>

                        <div class="form-group" style="display: flex;">
                            <div class="form-inline" style="width: 150px;">商品コメント</div>
                            <div class="form-inline" style="width: 500px;">
                                <div style="width: 400px; height: 200px">{!! nl2br(e($comment)) !!}</div>
                            </div>
                        </div>
                        <div class="form-group btn-wrapper">
                            @if(!empty($edit_flg))
                                <input type="submit" class="btn btn-default-blue" value="編集完了">
                            @else
                                <input type="submit" class="btn btn-default-blue" value="登録完了">
                            @endif
                        </div>
                        <div class="form-group btn-wrapper">
                            <button class="btn btn-back-blue" type="button" onclick="history.back()">前に戻る</button>
                        </div>

                    </form>

                </div>

                {{--                    <div class="form-group btn-wrapper">--}}
                {{--                        <input class="btn btn-back-blue" type="submit" value="確認画面へ">--}}
                {{--                    </div>--}}

        </div>
    </main>
@endsection
