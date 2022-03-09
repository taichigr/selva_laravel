@extends('layouts.app')
<?php
//dd(session()->all());
?>

@section('title', 'パスワード再設定')
@section('content')
    <header class="header"></header>

    <main>
        <div class="container">
            <h2></h2>
            <div style="margin-top: 10px">
                パスワード再設定の案内メールを送信しました。
            </div>
            <div style="margin-top: 10px">
                （まだパスワード再設定は完了していません）
            </div>
            <div style="margin-top: 10px">
                届きましたメールに記載されている
            </div>
            <div style="margin-top: 10px">
                『パスワード再設定URL』をクリックし、
            </div>
            <div style="margin-top: 10px">
                パスワードの再設定を完了させてください。
            </div>


            <div class="form-group btn-wrapper">
                    <a class="btn btn-back" href="{{ route('index') }}" >トップに戻る</a>
                </div>
        </div>
    </main>


@endsection
