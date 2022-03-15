@extends('layouts.app')
<?php
//dd(session()->all());

?>

@section('title', '会員情報変更')
@section('content')
    <main>
        <div class="container">
            <h2>会員情報変更</h2>
            <form method="post" action="{{ route('members.editmemberinfoconfirm') }}">
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
                        <input type="text" name="name_sei" required value="{{ old('name_sei') ?? $member->name_sei}}">
                    </div>
                    <div class="form-inline">
                        <lavel for="name_mei">名</lavel>
                        <input type="text" name="name_mei" required value="{{ old('name_mei') ?? $member->name_mei }}">
                    </div>

                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">ニックネーム</lavel>
                    <input style="width: 260px;" type="text" name="nickname" value="{{ old('nickname') ?? $member->nickname }}" required>
                </div>
                <div class="form-group">
                    性別
                    @if(!empty(old('gender')))
                        <div class="form-inline">
                            <label><input type="radio" name="gender" value="1" required {{ old('gender') == "1" ? "checked":"" }} >男性</label>
                        </div>
                        <div class="form-inline">
                            <label><input type="radio" name="gender" value="2" {{ old('gender') == "2" ? "checked":"" }}>女性</label>
                        </div>
                    @else
                        <div class="form-inline">
                            <label><input type="radio" name="gender" value="1" required {{ $member->gender == "1" ? "checked":"" }}>男性</label>
                        </div>
                        <div class="form-inline">
                            <label><input type="radio" name="gender" value="2" {{ $member->gender == "2" ? "checked":"" }}>女性</label>
                        </div>
                    @endif

                </div>



                <div class="form-group btn-wrapper">
                    <input class="btn btn-default" type="submit" value="確認画面へ">
                </div>
                <div class="form-group btn-wrapper">
                    <a class="btn btn-back" href="{{ route('members.mypage') }}" >マイページに戻る</a>
                </div>
            </form>
        </div>
    </main>
    <script>

    </script>
@endsection
