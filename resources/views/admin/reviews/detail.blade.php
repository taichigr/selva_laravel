@extends('layouts.app')
<?php
//dd(session()->all());
?>

    @section('title', '商品レビュー詳細')

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

            <div class="product-card" style="border-top: none; border-bottom: 1px solid #000">
                <div class="product-card-left">
                    <img src="{{ !empty($product->image_1) ? "/uploads/".$product->image_1: '' }}" alt="">
                </div>
                <div class="product-card-right" style="margin-right: 30px">
                    <div class="category-area">
                        商品ID {{ $product->id }}
                    </div>
                    <div class="name-area">
                        {{ $product->name }}
                    </div>
                    <div class="review-show-area">
                        <div style="margin-top: 10px">
                            総合評価
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


                                <div class="form-group">
                                    <div class="form-inline" style="width: 150px;">ID</div>
                                    <span style="margin-left: 80px">{{ $review_id }}</span>
                                </div>


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
                                    <a class="btn btn-back-blue" href="{{ route('admin.productreviewedit', ['review_id' => $review_id]) }}">編集</a>
                                    <input class="btn btn-back-blue" type="submit" value="削除" form="delete">
                                    <form method="post" action="{{ route('admin.productreviewdelete') }}" id="delete">
                                        @csrf
                                        <input type="hidden" name="review_id" value="{{ $review_id }}">
                                    </form>
                                </div>


            </div>

            {{--                    <div class="form-group btn-wrapper">--}}
            {{--                        <input class="btn btn-back-blue" type="submit" value="確認画面へ">--}}
            {{--                    </div>--}}

        </div>
    </main>
@endsection
