@extends('layouts.app')
<?php
//dd(session()->all());

?>

@if(!empty($member))
    @section('title', '会員編集')
@else
    @section('title', '会員登録')
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
            @if(!empty($member))
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
                        <label for="">ID</label>
                        <span>{{ $member->id }}</span>
                        <input type="hidden" name="id" value="{{ old('id') ?? $member->id }}">
                    </div>
                    <div class="form-group">
                        氏名
                        <div class="form-inline">
                            <lavel for="name_sei">姓</lavel>
                            <input type="text" name="name_sei" required value="{{ old('name_sei') ?? $member->name_sei }}">
                        </div>
                        <div class="form-inline">
                            <lavel for="name_mei">名</lavel>
                            <input type="text" name="name_mei" required value="{{ old('name_mei') ?? $member->name_mei }}">
                        </div>
                        <div></div>

                    </div>
                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">ニックネーム</lavel>
                        <input style="width: 260px;" type="text" name="nickname" value="{{ old('nickname') ?? $member->nickname }}" required>
                    </div>
                    <div class="form-group">
                        性別
                        <div class="form-inline">
                            @if(!empty(old('gender')))
                                <label><input type="radio" name="gender" value="1" required {{ old('gender') == "1" ? 'checked': '' }}>男性</label>
                            @else
                                <label><input type="radio" name="gender" value="1" required {{ $member->gender == "1" ? 'checked': '' }}>男性</label>
                            @endif
                        </div>
                        <div class="form-inline">
                            @if(!empty(old('gender')))
                                <label><input type="radio" name="gender" value="2" required {{ old('gender') == "2" ? 'checked': '' }}>女性</label>
                            @else
                                <label><input type="radio" name="gender" value="2" required {{ $member->gender == "2" ? 'checked': '' }}>女性</label>
                            @endif
                        </div>
                        <div class="err-msg">

                        </div>
                    </div>

                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                        <input style="width: 260px;" type="password" name="password">
                    </div>
                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">パスワード確認</lavel>
                        <input style="width: 260px;" type="password" name="password_confirmation">
                    </div>

                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">メールアドレス</lavel>
                        @if(!empty(old('email')))
                            <input style="width: 260px;" type="text" name="email" required value="{{ old('email') }}">
                        @else
                            <input style="width: 260px;" type="text" name="email" required value="{{ $member->email }}">
                        @endif
                    </div>


                    <div class="form-group btn-wrapper">
                        <input class="btn btn-back-blue" type="submit" value="確認画面へ">
                    </div>
                </form>
            @else


                <h2>会員登録</h2>

                <form method="post" action="{{ route('admin.memberregisterconfirm') }}">
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
                        <label for="">ID</label>
                        <span>登録後に自動採番</span>
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
                        <input class="btn btn-back-blue" type="submit" value="確認画面へ">
                    </div>
                </form>
            @endif

        </div>
    </main>
@endsection
