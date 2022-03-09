@extends('layouts.app')
<?php
//    dd(session()->all());
    //=======================
    // ログイン認証
    //=======================
    $dt = new \Carbon\Carbon();
//    dd($dt->timestamp);
//dd(url()->current());
//dd(route('members.login'));
$login_date = session('login_date');
//dd($login_date->timestamp);

if(!empty($login_date->timestamp)) {
    if(($login_date->timestamp + session('login_limit')) < $dt->timestamp) {
        session()->flush();
        redirect('members/index');
    } else {
        session()->put('login_date', \Carbon\Carbon::now());
        if (url()->current() === route('members.login')) {
            redirect('members/index');
        }
    }
} else {
    if (url()->current() !== route('members.login')) {
        redirect('members.login');
    }
}
?>

@section('title', 'トップ')
@section('content')
    @include('layouts.nav')
    <main>
        <div class="container">
            <h2>トップページ</h2>
        </div>
    </main>
@endsection
