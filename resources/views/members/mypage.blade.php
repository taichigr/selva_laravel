@extends('layouts.app')
<?php
//dd(session()->all());

?>

@section('title', 'マイページ')
@section('content')
    <main style="margin-top: 0">

        <header class="header">
            <div class="header-left">
                <h2 style="height: 60px; font-size: 20px; line-height: 60px">マイページ</h2>
            </div>
            <div class="header-right">
                <ul>
                    <li><a class="btn btn-header" href="{{ route('index') }}">トップに戻る</a></li>
                    <form method="post" action="{{ route('members.logout') }}">
                        @csrf
                        <li><button style="background-color: #ffe4d2; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>
                    </form>
                </ul>
            </div>
        </header>


        <div class="container" style="margin-top: 30px">
            <h2>マイページ</h2>
                <div class="form-group">
                    氏名
                    <div class="confirm-area inline">
                        {{$member['name_sei'].'　'.$member['name_mei']}}
                    </div>
                </div>

                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">ニックネーム</lavel>
                    <div class="confirm-area inline">
                        {{$member['nickname']}}
                    </div>
                </div>

                <div class="form-group">
                    性別
                    <div class="confirm-area inline">
                        @if($member['gender'] == 1)
                            男性
                        @else
                            女性
                        @endif
                    </div>
                </div>

                <div class="form-group" style="text-align: center; margin-top: 30px; margin-bottom: 30px">
                    <a class="btn btn-default-blue" href="">会員情報変更</a>
                </div>

                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                    セキュリティのため非表示
                </div>

                <div class="form-group" style="text-align: center; margin-top: 30px; margin-bottom: 30px">
                    <a class="btn btn-default-blue" href="">パスワード変更</a>
                </div>

                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">メールアドレス</lavel>
                    <div class="confirm-area inline" style="color: #406bca">
                        {{$member['email']}}
                    </div>
                </div>

                <div class="form-group" style="text-align: center; margin-top: 30px; margin-bottom: 30px">
                    <a class="btn btn-default-blue" href="">メールアドレス変更</a>
                </div>

                <div class="form-group">
                    <div class="btn-wrapper">
                        <a class="btn btn-back-blue" href="{{ route('members.withdrawshow') }}">退会</a>
                    </div>
                </div>


        </div>
    </main>
@endsection
