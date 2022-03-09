@extends('layouts.app')
<?php
//dd(session()->all());

?>

@section('title', '会員登録')
@section('content')
    <main>
        <div class="container">
            <h2>会員情報登録フォーム</h2>
            <form method="post" action="{{ route('members.regist_confirm') }}">
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
                <div class="form-group">
                    氏名
                    <div class="form-inline">
                        <lavel for="name_sei">姓</lavel>
                        <input type="text" name="name_sei" required value="{{ old('name_sei') }}">
                    </div>
                    <div class="form-inline">
                        <lavel for="name_mei">名</lavel>
                        <input type="text" name="name_mei" required value="{{ old('name_mei') }}">
                    </div>
                    <div></div>
                    <div class="err-msg">

                    </div>
                    <div class="err-msg">

                    </div>
                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">ニックネーム</lavel>
                    <input style="width: 260px;" type="text" name="nickname" value="{{ old('nickname') }}" required>
                </div>
                <div class="form-group">
                    性別
                    <div class="form-inline">
                        <label><input type="radio" name="gender" value="1" required <?php if(!empty(old('gender')) && old('gender') === "1") echo "checked" ?>>男性</label>
                    </div>
                    <div class="form-inline">
                        <label><input type="radio" name="gender" value="2" <?php if(!empty(old('gender')) && old('gender') === "2") echo "checked" ?>>女性</label>
                    </div>
                    <div class="err-msg">

                    </div>
                </div>

                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                    <input style="width: 260px;" type="password" name="password" required>
                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">パスワード確認</lavel>
                    <input style="width: 260px;" type="password" name="password_confirmation" required>
                </div>
                <div class="err-msg">

                </div>
                <div class="err-msg">

                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">メールアドレス</lavel>
                    <input style="width: 260px;" type="text" name="email" required value="{{old('email')}}">
                </div>
                <div class="err-msg">

                </div>

                <div class="form-group btn-wrapper">
                    <input class="btn btn-default" type="submit" value="確認画面へ">
                </div>
                <div class="form-group btn-wrapper">
                    <a class="btn btn-back" href="{{ route('index') }}" >トップに戻る</a>
                </div>
            </form>
        </div>
    </main>
@endsection
