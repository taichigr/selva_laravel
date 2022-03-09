@extends('layouts.app')
<?php
//dd(session()->all());
?>

@section('title', 'パスワード再設定')
@section('content')

    <header class="header"></header>
    <main>
        <div class="container">
            <h2>パスワード再設定</h2>
            <div style="margin-top: 10px">
                パスワード再設定用の URL を記載したメールを送信します。
            </div>
            <div style="margin-top: 10px">
                ご登録されたメールアドレスを入力してください。
            </div>
            <form method="post" action="{{ route('password.confirm') }}">
                @csrf
                <div class="form-group" style="margin-top: 30px">
                    <lavel style="width: 115px; display: inline-block">メールアドレス</lavel>
                    <input style="width: 260px;" type="text" name="email" required value="{{ old('email') }}">
                </div>

                <div class="err-msg">
                    @if ($errors->any())
                        <div class="card-text text-left alert alert-danger">
                            <ul class="mb-0">
                                <li>メールアドレスを再入力してください</li>
                            </ul>
                        </div>
                    @endif
                    @if (!empty($errmsg))
                        <div class="card-text text-left alert alert-danger">
                            <ul class="mb-0">
                                <li>メールアドレスを再入力してください</li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="form-group btn-wrapper">
                    <input class="btn btn-default" type="submit" value="送信する">
                </div>
                <div class="form-group btn-wrapper">
                    <a class="btn btn-back" href="{{ route('index') }}" >トップに戻る</a>
                </div>
            </form>
        </div>
    </main>


@endsection
