@extends('layouts.app')


@section('title', '会員登録')
@section('content')
    <main>
        <div class="container">
            <h2>会員情報登録フォーム</h2>
            <form method="post" action="{{ route('members.regist_confirm') }}">
                @csrf
                <div class="err-msg">

                </div>
                <div class="form-group">
                    氏名
                    <div class="form-inline">
                        <lavel for="name_sei">姓</lavel>
                        <input type="text" name="name_sei" required value="<?php if(!empty($name_sei)) echo $name_sei; ?>">
                    </div>
                    <div class="form-inline">
                        <lavel for="name_mei">名</lavel>
                        <input type="text" name="name_mei" required value="<?php if(!empty($name_mei)) echo $name_mei; ?>">
                    </div>
                    <div></div>
                    <div class="err-msg">

                    </div>
                    <div class="err-msg">

                    </div>
                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">ニックネーム</lavel>
                    <input style="width: 260px;" type="text" name="nickname" required>
                </div>
                <div class="form-group">
                    性別
                    <div class="form-inline">
                        <label><input type="radio" name="gender" value="1" required <?php if(!empty($gender) && $gender === "1") echo "checked" ?>>男性</label>
                    </div>
                    <div class="form-inline">
                        <label><input type="radio" name="gender" value="2" <?php if(!empty($gender) && $gender === "2") echo "checked" ?>>女性</label>
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
                    <input style="width: 260px;" type="password" name="password-confirm" required>
                </div>
                <div class="err-msg">

                </div>
                <div class="err-msg">

                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">メールアドレス</lavel>
                    <input style="width: 260px;" type="text" name="email" required value="<?php if(!empty($email)) echo $email ?>">
                </div>
                <div class="err-msg">

                </div>

                <div class="form-group btn-wrapper">
                    <input class="btn btn-default" type="submit" value="確認画面へ">
                </div>
                <div class="form-group btn-wrapper">
                    <a class="btn btn-back" href="index.php" >トップに戻る</a>
                </div>
            </form>
        </div>
    </main>
@endsection
