@extends('layouts.app')
<?php
//dd(session()->all());
//dd('退会');
?>

@section('title', '退会ページ')
@section('content')
    <main style="margin-top: 0">

        <header class="header">
            <div class="header-left">
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
            <p>退会します。よろしいですか？</p>
            <div class="form-group">
                <div class="btn-wrapper">
                    <a class="btn btn-back-blue" href="{{ route('members.mypage') }}">マイページに戻る</a>
                </div>
                <form action="{{ route('members.withdrawcomplete') }}" method="post">
                    <div class="btn-wrapper">
                        @csrf
                        <button class="btn btn-default-blue" type="submit">退会する</button>
                    </div>
                </form>

            </div>

        </div>
    </main>
@endsection
