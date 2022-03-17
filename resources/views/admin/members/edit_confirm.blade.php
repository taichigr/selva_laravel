@extends('layouts.app')
<?php
//dd(session()->all());

?>

@if($member_register_flg == true)
    @section('title', '会員登録')
@else
    @section('title', '会員編集')
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
            @if($member_register_flg == true)
                <h2>会員登録</h2>
                <form method="post" action="{{ route('admin.memberregistercomplete') }}">
                    @csrf
                    <input type="hidden" name="name_sei" value="{{ $name_sei }}">
                    <input type="hidden" name="name_mei" value="{{ $name_mei }}">
                    <input type="hidden" name="nickname" value="{{ $nickname }}">
                    <input type="hidden" name="gender" value="{{ $gender }}">
                    <input type="hidden" name="password" value="{{ $password }}">
                    <input type="hidden" name="email" value="{{ $email }}">

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
                            <span>{{ $name_sei }}</span>
                        </div>
                        <div class="form-inline" style="margin-left: 40px">
                            <lavel for="name_mei">名</lavel>
                            <span>{{ $name_mei }}</span>
                        </div>
                        <div></div>

                    </div>
                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">ニックネーム</lavel>
                        <span style="width: 260px;">{{ $nickname }}</span>
                    </div>
                    <div class="form-group">
                        性別
                        <div class="form-inline">
                        <span>
                            @if($gender == "1")
                                男性
                            @else
                                女性
                            @endif
                        </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                        <span>セキュリティのため非表示</span>
                    </div>

                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">メールアドレス</lavel>
                        <span style="width: 260px;">{{ $email }}</span>
                    </div>


                    <div class="form-group btn-wrapper">
                        <input class="btn btn-back-blue" type="submit" value="登録完了">
                        <button class="btn btn-back-blue" type="button" onclick="history.back()">前へ戻る</button>
                    </div>
                </form>



            @else
                <h2>会員編集</h2>
                <form method="post" action="{{ route('admin.membereditcomplete') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="name_sei" value="{{ $name_sei }}">
                    <input type="hidden" name="name_mei" value="{{ $name_mei }}">
                    <input type="hidden" name="nickname" value="{{ $nickname }}">
                    <input type="hidden" name="gender" value="{{ $gender }}">
                    @if(!empty($password))
                        <input type="hidden" name="password" value="{{ $password }}">
                    @endif
                    <input type="hidden" name="email" value="{{ $email }}">

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
                            <span>{{ $name_sei }}</span>
                        </div>
                        <div class="form-inline" style="margin-left: 40px">
                            <lavel for="name_mei">名</lavel>
                            <span>{{ $name_mei }}</span>
                        </div>
                        <div></div>

                    </div>
                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">ニックネーム</lavel>
                        <span style="width: 260px;">{{ $nickname }}</span>
                    </div>
                    <div class="form-group">
                        性別
                        <div class="form-inline">
                        <span>
                            @if($gender == "1")
                                男性
                            @else
                                女性
                            @endif
                        </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                        <span>セキュリティのため非表示</span>
                    </div>

                    <div class="form-group">
                        <lavel style="width: 115px; display: inline-block">メールアドレス</lavel>
                        <span style="width: 260px;">{{ $email }}</span>
                    </div>


                    <div class="form-group btn-wrapper">
                        <input class="btn btn-back-blue" type="submit" value="編集完了">
                        <button class="btn btn-back-blue" type="button" onclick="history.back()">前へ戻る</button>
                    </div>
                </form>



            @endif

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
