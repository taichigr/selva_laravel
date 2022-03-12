@extends('layouts.app')
<?php
//dd(session()->all());
?>

@section('title', '会員情報変更確認画面')
@section('content')
    <main>
        <div class="container">
            <h2>会員情報変更確認画面</h2>
            <form method="post" action="{{ route('members.editmemberinfocomplete') }}">
                @csrf
                <input type="hidden" name="name_sei" value="{{ $member['name_sei'] }}">
                <input type="hidden" name="name_mei" value="{{ $member['name_mei'] }}">
                <input type="hidden" name="nickname" value="{{ $member['nickname'] }}">
                <input type="hidden" name="gender" value="{{ $member['gender'] }}">

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
                        <p>{{$member['name_sei']}}</p>
                    </div>
                    <div class="form-inline">
                        <lavel for="name_mei">名</lavel>
                        <p>{{$member['name_mei']}}</p>
                    </div>

                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">ニックネーム</lavel>
                    <p>{{ $member['nickname']  }}</p>
                </div>
                <div class="form-group">
                    性別
                    <div class="form-inline">
                        <label><input type="radio" name="gender" value="1" required {{ $member['gender'] == "1" ? "checked":"" }}>男性</label>
                    </div>
                    <div class="form-inline">
                        <label><input type="radio" name="gender" value="2" {{ $member['gender'] == "2" ? "checked":"" }}>女性</label>
                    </div>
                </div>



                <div class="form-group btn-wrapper">
                    <input class="btn btn-default" type="submit" value="変更完了">
                </div>
                <div class="form-group btn-wrapper">
                    <a class="btn btn-back" href="{{ route('members.mypage') }}" >マイページに戻る</a>
                </div>
            </form>
        </div>
    </main>
@endsection
