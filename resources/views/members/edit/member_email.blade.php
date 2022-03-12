@extends('layouts.app')
<?php
//dd(session()->all());

?>

@section('title', 'メールアドレス変更')
@section('content')
    <main>
        <div class="container">
            <h2>メールアドレス変更</h2>
            <form method="post" action="{{ route('members.editemailconfirm') }}">
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
                    <lavel style="width: 180px; display: inline-block">現在のメールアドレス</lavel>
                    <div class="confirm-area inline" style="color: #406bca">
                        {{ $member->email }}
                    </div>
                </div>
                <div class="form-group">
                    <lavel style="width: 180px; display: inline-block">変更後のメールアドレス</lavel>
                    <input style="width: 260px;" type="text" name="email" required value="{{old('email')}}">
                </div>


                <div class="form-group btn-wrapper">
                    <input class="btn btn-default" type="submit" value="認証メール送信">
                </div>
                <div class="form-group btn-wrapper">
                    <a class="btn btn-back" href="{{ route('index') }}" >トップに戻る</a>
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
