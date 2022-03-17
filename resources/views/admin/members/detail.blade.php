@extends('layouts.app')
<?php
//dd(session()->all());

?>
@section('title', '会員詳細')

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
                <li><a class="btn btn-admin-header" style="border: solid 1px #000" href="{{ route('admin.membershow') }}">一覧へ戻る</a></li>
                {{--                <form method="post" action="">--}}
{{--                    @csrf--}}
{{--                    <li><button style="background-color: #cfcfcf; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>--}}
{{--                </form>--}}
                <?php endif ?>
            </ul>
        </div>
    </header>


    <main class="admin-main">
        <div class="container admin-container">

                    <div class="form-group" style="margin-top: 20px">
                        <label style="width: 115px; display: inline-block;" for="">ID</label>
                        <span>{{ $member->id }}</span>
                    </div>
                    <div class="form-group" style="margin-top: 20px">
                        <label style="width: 115px; display: inline-block" for="">氏名</label>
                            <span>{{ $member->name_sei }}　{{ $member->name_mei }}</span>

                        <div></div>

                    </div>
                    <div class="form-group" style="margin-top: 20px">
                        <lavel style="width: 115px; display: inline-block">ニックネーム</lavel>
                        <span style="width: 260px;">{{ $member->nickname }}</span>
                    </div>
                    <div class="form-group" style="margin-top: 20px">
                        <label style="width: 115px; display: inline-block" for="">性別</label>
                        <span>
                            @if($member->gender == "1")
                                男性
                            @else
                                女性
                            @endif
                        </span>
                    </div>

                    <div class="form-group" style="margin-top: 20px">
                        <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                        <span>セキュリティのため非表示</span>
                    </div>

                    <div class="form-group" style="margin-top: 20px">
                        <lavel style="width: 115px; display: inline-block">メールアドレス</lavel>
                        <span style="width: 260px; color: #406bca">{{ $member->email }}</span>
                    </div>


                    <div class="form-group btn-wrapper">
                        <a class="btn btn-back-blue" href="{{ route('admin.membereditshow', ['member_id'=> $member->id]) }}">編集</a>
                        <input class="btn btn-back-blue" type="submit" value="削除" form="delete">
                        <form method="POST" action="{{ route('admin.memberdelete', ['member_id' => $member->id]) }}" id="delete">
                            @csrf
                        </form>
                    </div>




        </div>
    </main>
    <script>
        $(function () {
            $('form').submit(function () {
                $(this).find(':submit').prop('disabled', 'true');
            });
        })
    </script>
@endsection
