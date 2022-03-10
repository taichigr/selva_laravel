@extends('layouts.app')
<?php
//dd(session()->all());
//    if(!empty($prevEmail)){dd($prevEmail);}

?>

@section('title', 'ログイン')
@section('content')

<main>
    <div class="container">
        <h2>ログイン</h2>
        <form method="post" action="{{ route('members.login') }}">
            @csrf
            <div class="form-group">
                <lavel style="width: 115px; display: inline-block">メールアドレス（ID）</lavel>
                <input style="width: 260px;" type="text" name="email" required value="{{ !empty($prevEmail)?$prevEmail: old('email') }}">
            </div>
            <div class="form-group">
                <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                <input style="width: 260px;" type="password" name="password" required>
            </div>
            <div style="text-align: right; color: #406bca; margin-right: 177px">
                <a href="{{ route('password.confirm') }}">パスワードを忘れた方はこちら</a>
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
                <input class="btn btn-default" type="submit" value="ログイン">
            </div>
            <div class="form-group btn-wrapper">
                <a class="btn btn-back" href="{{ route('index') }}" >トップに戻る</a>
            </div>
        </form>
    </div>
</main>


@endsection
