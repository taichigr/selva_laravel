@extends('layouts.app')
<?php
//dd(session()->all());
?>

@section('title', '商品カテゴリ詳細')
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
                <li><a class="btn btn-admin-header" style="border: solid 1px #000" href="{{ route('admin.productscategoryshow') }}">一覧へ戻る</a></li>

                {{--                <form method="post" action="">--}}
{{--                    @csrf--}}
{{--                    <li><button style="background-color: #cfcfcf; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>--}}
{{--                </form>--}}
                <?php endif ?>
            </ul>
        </div>
    </header>


    <main class="admin-main">
        <div class="container admin-container">
                <h2>商品カテゴリ詳細</h2>




                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品大カテゴリID</lavel>
                        <span>{{ $product_category->id }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品大カテゴリ</lavel>
                        <span>{{ $product_category->name }}</span>
                    </div>

            @foreach($product_subcategories as $index => $product_subcategory)
                <div class="form-group" style="margin-bottom: 20px">
                    @if($index == 0)
                    <lavel style="width: 180px; display: inline-block;">商品小カテゴリ</lavel>
                    @else
                    <lavel style="width: 180px; display: inline-block;"></lavel>
                    @endif
                        <span>{{ $product_subcategory->name }}</span>
                </div>
            @endforeach



                    <form method="post" action="{{ route('admin.productscategorydelete') }}" id="delete">
                        @csrf
                        <input type="hidden" name="product_category_id" value="{{ $product_category->id }}">
                    </form>
                    <div class="form-group btn-wrapper">
                        <a class="btn btn-back-blue" href="{{ route('admin.productscategoryedit', ['product_category_id' => $product_category->id]) }}">編集</a>
                        <input class="btn btn-back-blue" type="submit" value="削除" form="delete">
                    </div>

        </div>
    </main>
@endsection
