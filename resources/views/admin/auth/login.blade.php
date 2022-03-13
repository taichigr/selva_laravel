@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
?>

@section('title', '管理ログイン')
@section('content')

    @include('layouts.admin_nav')

<main class="admin-main">
    <div class="container admin-container">
        <h2>管理画面</h2>
        <div>
            <form method="post" action="{{ route('admin.login') }}">
                @csrf
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">ログインID</lavel>
                    @if(!empty($login_id))
                        <input style="width: 260px;" type="text" name="login_id" required value="{{ $login_id }}">
                    @else
                        <input style="width: 260px;" type="text" name="login_id" required value="{{ old('login_id') }}">
                    @endif
                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                    <input style="width: 260px;" type="password" name="password" required>
                </div>

                <div class="err-msg">
                    @if ($errors->any())
                        <div class="card-text text-left alert alert-danger">
                            <ul class="mb-0">
                                <li>IDもしくはパスワードが間違っています</li>
                            </ul>
                        </div>
                    @endif
                    @if (!empty($errmsg))
                        <div class="card-text text-left alert alert-danger">
                            <ul class="mb-0">
                                <li>IDもしくはパスワードが間違っています</li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="form-group btn-wrapper">
                    <input class="btn btn-default-blue" type="submit" value="ログイン">
                </div>

            </form>
        </div>
    </div>
</main>

@endsection
