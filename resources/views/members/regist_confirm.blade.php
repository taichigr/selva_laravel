@extends('layouts.app')


@section('title', '会員登録確認')
@section('content')


<script src="https://code.jquery.com/jquery-3.0.0.js" integrity="sha256-jrPLZ+8vDxt2FnE1zvZXCkCcebI/C8Dt5xyaQBjxQIo=" crossorigin="anonymous"></script>
<main>
    <div class="container">
        <h2>会員情報登録フォーム</h2>
        <form method="post" action="{{ route('members.regist_complete') }}">
            @csrf
            <input type="hidden" name="name_sei" value="{{$member['name_sei']}}">
            <input type="hidden" name="name_mei" value="{{$member['name_mei']}}">
            <input type="hidden" name="nickname" value="{{$member['nickname']}}">
            <input type="hidden" name="gender" value="{{$member['gender']}}">
            <input type="hidden" name="password" value="{{$member['password']}}">
            <input type="hidden" name="email" value="{{$member['email']}}">

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

            <div class="form-group">
                <lavel style="width: 115px; display: inline-block">パスワード</lavel>
                セキュリティのため非表示
            </div>

            <div class="form-group">
                <lavel style="width: 115px; display: inline-block">メールアドレス</lavel>
                <div class="confirm-area inline" style="color: #406bca">
                    {{$member['email']}}
                </div>
            </div>

            <div class="form-group btn-wrapper">
                <input class="btn btn-default" type="submit" value="登録完了">
            </div>
            <div class="form-group btn-wrapper">
                <button class="btn btn-back" type="button" onclick="history.back()">前に戻る</button>
            </div>
            <div class="form-group btn-wrapper">
                <a class="btn btn-back" href="index.php" >トップに戻る</a>
            </div>
        </form>
    </div>
</main>

<script>
    $(function() {
        $('form').submit(function () {
            $(this).find(':submit').prop('disabled', 'true');
        });
    })
</script>

@endsection
