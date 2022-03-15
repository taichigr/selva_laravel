@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
//    dd(session()->all());
?>

@section('title', '商品詳細')
@section('content')
    <header class="admin-header">
        <div class="header-left">
            <h1>商品詳細</h1>

        </div>
        <div class="header-right">

            <ul>
                <?php if(!empty(session('admin_login_date'))): ?>
                <li>
                    ようこそ
                    @if(!empty(session('admin_name')))
                        {{ session('admin_name') }}
                    @endif
                    さん
                </li>
                <?php endif ?>
                {{--            <li><a class="btn btn-header" href="">商品一覧</a></li>--}}
                <?php if(empty(session('admin_login_date'))): ?>
                <li><a class="btn btn-admin-header" href="{{ route('admin.login') }}">ログイン</a></li>
                <?php endif ?>

                <?php if(!empty(session('admin_login_date'))): ?>
                <form method="post" action="{{ route('admin.logout') }}">
                    @csrf
                    <li><button style="background-color: #cfcfcf; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>
                </form>
                <?php endif ?>
            </ul>
        </div>
    </header>

    {{--    @include('layouts.admin_nav')--}}
    <main class="admin-main">
        <div class="container admin-container">

            <div class="form-group">
                <lavel style="width: 115px; display: inline-block">商品ID</lavel>
                <span>{{ $product_id }}</span>
            </div>
            <div class="form-group">
                <lavel style="width: 115px; display: inline-block">商品名</lavel>
                <span>{{ $name }}</span>
            </div>

            <div class="form-group">
                商品カテゴリ
                <div class="form-inline">
                    @foreach($product_categories as $product_category)
                        @if($product_category->id == $product_category_id)
                            <p>{{ $product_category->name }} ＞
                                @endif
                                @endforeach
                                {{--                        小カテゴリーをjQueryで生成--}}
                                @foreach($product_subcategories as $product_subcategory)
                                    @if($product_subcategory->id == $product_subcategory_id)
                                        {{ $product_subcategory->name }}</p>
                        @endif
                    @endforeach
                </div>
            </div>


            <div class="form-group">
                <span style="width: 115px; display: inline-block">商品写真</span>
                <span>写真１</span>
                <div style="text-align: center">
                    <div class="preview-image-wrapper">
                        <img class="js-preview1 upload-image" src="{{ !empty($image_1) ? "/uploads/".$image_1: '' }}">
                    </div>
                    <input type="hidden" name="image_1" value="{{ $image_1 }}">
                </div>
            </div>

            <div class="form-group">
                <span style="width: 115px; display: inline-block"></span>
                <span>写真2</span>
                <div style="text-align: center">
                    <div class="preview-image-wrapper">
                        <img class="js-preview1 upload-image" src="{{ !empty($image_2) ? "/uploads/".$image_2: '' }}">
                    </div>
                    <input type="hidden" name="image_2" value="{{ $image_2 }}">
                </div>
            </div>
            <div class="form-group">
                <span style="width: 115px; display: inline-block"></span>
                <span>写真3</span>
                <div style="text-align: center">

                    <div class="preview-image-wrapper">
                        <img class="js-preview1 upload-image" src="{{ !empty($image_3) ? "/uploads/".$image_3: '' }}">
                    </div>
                    <input type="hidden" name="image_3" value="{{ $image_3 }}">
                </div>
            </div>
            <div class="form-group">
                <span style="width: 115px; display: inline-block"></span>
                <span>写真4</span>
                <div style="text-align: center">
                    <div class="js-image1-error-target err-msg">
                    </div>
                    <div class="preview-image-wrapper">
                        <img class="js-preview1 upload-image" src="{{ !empty($image_4) ? "/uploads/".$image_4: '' }}">
                    </div>
                    <input type="hidden" name="image_4" value="{{ $image_4 }}">
                </div>
            </div>
            <div class="form-group" style="display: flex; padding-top: 20px">
                <div style="width: 115px; display: inline-block">商品説明</div>
                <div style="width: 260px;">
                    {!! nl2br(e($product_content)) !!}
                    {{--                        {{ $product->product_content }}--}}
                </div>
            </div>

        </div>
        <div class="admin-header" style="height: 70px; width: 100%">
            <div style="width: 80%; margin: 0 auto; display: flex">
                <h2 style="width: 200px">総合評価</h2>
                <p>
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
                </p>
            </div>
        </div>
        <div class="container admin-container">
            <div class="review-show-area">
                @if(empty($reviews[0]))
                    <h2>
                        レビューはありません
                    </h2>
                @else
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="form-group" style="display: flex">
                            <div class="form-inline" style="width: 150px; font-weight: bold">{{ $review->member->nickname }}さん</div>
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
                @endif
                <div class="pagination" style="width: auto">
                    {{ $reviews->appends(['product_id' => $product_id])->links() }}

                </div>

            </div>


            <div class="form-group" style="text-align: center">
                <a class="btn btn-back-blue" style="height: 20px" href="{{ route('admin.producteditshow', ['product_id' => $product_id]) }}">編集</a>
                <input class="btn btn-back-blue" type="submit" value="削除" form="delete">
                <form method="post" action="{{ route('admin.productdelete') }}" id="delete">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product_id }}">
                </form>

            </div>
        </div>
    </main>


@endsection
