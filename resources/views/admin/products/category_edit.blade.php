@extends('layouts.app')
<?php
//dd(session()->all());

?>

@if(!empty($product_categories))
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
            @if(!empty($product_categories))
                <h2>会員編集</h2>

                <form method="post" action="{{ route('admin.membereditconfirm') }}">
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

                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">商品第カテゴリID</lavel>
                        @if(!empty(old('product_categories_id')))
                            <input style="width: 260px;" type="text" name="email" required value="{{ old('product_categories_id') }}">
                        @else
                            <input style="width: 260px;" type="text" name="email" required value="">
                        @endif
                    </div>


                    <div class="form-group btn-wrapper">
                        <input class="btn btn-back-blue" type="submit" value="確認画面へ">
                    </div>
                </form>
            @else


                <h2>商品カテゴリ登録</h2>

                <form method="post" action="{{ route("admin.productscategoryregisterconfirm") }}">
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
                    </div>


                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品大カテゴリID</lavel>
                        <span>登録後に自動採番</span>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品大カテゴリ</lavel>
                        <input style="width: 260px;" type="text" name="product_category_name" required value="{{old('product_category_name')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;">商品小カテゴリ</lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name1" required value="{{old('product_subcategory_name1')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name2" value="{{old('product_subcategory_name2')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name3" value="{{old('product_subcategory_name3')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name4" value="{{old('product_subcategory_name4')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name5" value="{{old('product_subcategory_name5')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name6" value="{{old('product_subcategory_name6')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name7" value="{{old('product_subcategory_name7')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name8" value="{{old('product_subcategory_name8')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name9" value="{{old('product_subcategory_name9')}}">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px">
                        <lavel style="width: 180px; display: inline-block;"></lavel>
                        <input style="width: 260px;" type="text" name="product_subcategory_name10" value="{{old('product_subcategory_name10')}}">
                    </div>


                    <div class="form-group btn-wrapper">
                        <input class="btn btn-back-blue" type="submit" value="確認画面へ">
                    </div>
                </form>
            @endif

        </div>
    </main>
@endsection
