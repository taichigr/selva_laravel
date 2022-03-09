@extends('layouts.app')
<?php
//dd(session()->all());

?>

@section('title', 'パスワード再設定')
@section('content')
    <main>
        <div class="container">
            <h2>パスワード再設定</h2>
            <form method="post" action="{{ route('password.update') }}">
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
                    <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                    <input style="width: 260px;" type="password" name="password" required>
                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">パスワード確認</lavel>
                    <input style="width: 260px;" type="password" name="password_confirmation" required>
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
