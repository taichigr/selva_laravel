

@extends('layouts.app')


@section('title', '会員登録完了')
@section('content')


    <main>
    <div class="container register-complete-container">
        <h2>会員登録完了</h2>
        <p class="register-complete-text">会員登録が完了しました。</p>
        <div class="form-group btn-wrapper">
            <a class="btn btn-back" href="{{ route('index') }}" >トップに戻る</a>
        </div>
    </div>

</main>
