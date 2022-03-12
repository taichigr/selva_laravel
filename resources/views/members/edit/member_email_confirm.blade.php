@extends('layouts.app')
<?php
//dd(session()->all());

?>

@section('title', 'メールアドレス変更認証コード入力')
@section('content')
    <main>
        <div class="container">
            <h2>メールアドレス変更　認証コード入力</h2>
            <div>
                （＊メールアドレスの変更はまだ完了していません）
            </div>
            <div>
                変更後のメールアドレスにお送りしましたメールに記載されている「認証コード」を入力してください。
            </div>
            <form method="post" action="{{ route('members.editemailcomplete') }}">
                @csrf
                <input type="hidden" name="newemail" value="{{ $newemail }}">
                <div class="err-msg">
                    @if ($errors->any())
                        <div class="card-text text-left alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>半角で入力してください</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        @if (!empty($err_msg))
                            <div class="card-text text-left alert alert-danger">
                                <ul class="mb-0">
                                    <li>{{$err_msg}}</li>
                                </ul>
                            </div>
                        @endif
                </div>

                <div class="form-group">
                    <lavel style="width: 180px; display: inline-block">認証コード</lavel>
                    <input style="width: 260px;" type="text" name="auth_code" required value="{{old('auth_code')}}">
                </div>


                <div class="form-group btn-wrapper">
                    <input class="btn btn-default" type="submit" value="認証コードを送信してメールアドレスの変更を完了する">
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
