@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
//    dd(session()->all());
?>

@section('title', '管理画面トップ画面')
@section('content')
    <header class="admin-header">
        <div class="header-left">
            <h1>管理画面メインメニュー</h1>

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
        <h2>トップページ</h2>

        <div class="form-group">
            <a class="btn btn-back-blue" href="{{ route('admin.membershow') }}">会員一覧</a>
        </div>
    </div>
</main>


@endsection
