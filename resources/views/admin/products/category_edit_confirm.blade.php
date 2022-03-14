@extends('layouts.app')
<?php
//dd(session()->all());
// TODO 編集か、登録かをフラグで管理
?>

@if(!empty($edit_flg))
    @section('title', '商品カテゴリ編集')
@else
    @section('title', '商品カテゴリ登録')
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
                <h2>商品カテゴリ編集</h2>

                <form method="post" action="{{ route("admin.productscategoryeditcomplete") }}">
                    @csrf
                    <input type="hidden" name="product_category_id" value="{{ $product_category_id }}">
                    <input type="hidden" name="product_category_name" value="{{ $product_category_name }}">
                    <input type="hidden" name="product_subcategory_name1" value="{{ $product_subcategory_name1 }}">
                    <input type="hidden" name="product_subcategory_name2" value="{{ $product_subcategory_name2 }}">
                    <input type="hidden" name="product_subcategory_name3" value="{{ $product_subcategory_name3 }}">
                    <input type="hidden" name="product_subcategory_name4" value="{{ $product_subcategory_name4 }}">
                    <input type="hidden" name="product_subcategory_name5" value="{{ $product_subcategory_name5 }}">
                    <input type="hidden" name="product_subcategory_name6" value="{{ $product_subcategory_name6 }}">
                    <input type="hidden" name="product_subcategory_name7" value="{{ $product_subcategory_name7 }}">
                    <input type="hidden" name="product_subcategory_name8" value="{{ $product_subcategory_name8 }}">
                    <input type="hidden" name="product_subcategory_name9" value="{{ $product_subcategory_name9 }}">
                    <input type="hidden" name="product_subcategory_name10" value="{{ $product_subcategory_name10 }}">

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品大カテゴリID</lavel>
                        <span>{{ $product_category_id }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品大カテゴリ</lavel>
                        <span>{{ $product_category_name }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品小カテゴリ</lavel>
                        <span>{{ $product_subcategory_name1 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name2 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name3 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name4 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name5 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name6 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name7 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name8 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name9 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name10 }}</span>
                    </div>


                    <div class="form-group btn-wrapper">
                        <input class="btn btn-back-blue" type="submit" value="編集完了">
                    </div>
                </form>
            @else


                <h2>商品カテゴリ登録</h2>

                <form method="post" action="{{ route("admin.productscategoryregistercomplete") }}">
                    @csrf
                    <input type="hidden" name="product_category_name" value="{{ $product_category_name }}">
                    <input type="hidden" name="product_subcategory_name1" value="{{ $product_subcategory_name1 }}">
                    <input type="hidden" name="product_subcategory_name2" value="{{ $product_subcategory_name2 }}">
                    <input type="hidden" name="product_subcategory_name3" value="{{ $product_subcategory_name3 }}">
                    <input type="hidden" name="product_subcategory_name4" value="{{ $product_subcategory_name4 }}">
                    <input type="hidden" name="product_subcategory_name5" value="{{ $product_subcategory_name5 }}">
                    <input type="hidden" name="product_subcategory_name6" value="{{ $product_subcategory_name6 }}">
                    <input type="hidden" name="product_subcategory_name7" value="{{ $product_subcategory_name7 }}">
                    <input type="hidden" name="product_subcategory_name8" value="{{ $product_subcategory_name8 }}">
                    <input type="hidden" name="product_subcategory_name9" value="{{ $product_subcategory_name9 }}">
                    <input type="hidden" name="product_subcategory_name10" value="{{ $product_subcategory_name10 }}">

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品大カテゴリID</lavel>
                        <span>登録後に自動採番</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品大カテゴリ</lavel>
                        <span>{{ $product_category_name }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品小カテゴリ</lavel>
                        <span>{{ $product_subcategory_name1 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name2 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name3 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name4 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name5 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name6 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name7 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name8 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name9 }}</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <span>{{ $product_subcategory_name10 }}</span>
                    </div>


                    <div class="form-group btn-wrapper">
                        <input class="btn btn-back-blue" type="submit" value="登録">
                    </div>
                </form>
            @endif

        </div>
    </main>
@endsection
