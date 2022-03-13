@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
//    dd(session()->all());
//    dd($members);
?>

@section('title', '会員一覧')
@section('content')
    <header class="admin-header">
        <div class="header-left">
            <h1>会員一覧</h1>

        </div>
        <div class="header-right">

            <ul>
                <?php if(!empty(session('admin_login_date'))): ?>
                <li>
                    ようこそ
                    @if(!empty(session('admin_name')))
                        {{ session('admin_name') }}
                    @endif
                    さん
                </li>
                <?php endif ?>
                {{--            <li><a class="btn btn-header" href="">商品一覧</a></li>--}}
                <?php if(empty(session('admin_login_date'))): ?>
                <li><a class="btn btn-admin-header" href="{{ route('admin.login') }}">ログイン</a></li>
                <?php endif ?>

                <?php if(!empty(session('admin_login_date'))): ?>
                <form method="post" action="{{ route('admin.logout') }}">
                    @csrf
                    <li><button style="background-color: #cfcfcf; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>
                </form>
                <?php endif ?>
            </ul>
        </div>
    </header>

    {{--    @include('layouts.admin_nav')--}}
    <main class="admin-main">
        <div class="container admin-container">

            <div class="form-group">
                <div class="btn-wrapper" style="text-align: left">
                    <a class="btn btn-default-blue" href="{{ route('admin.memberregister') }}">会員登録</a>
                </div>
            </div>

            <div class="member-form-container">


                <form id="member-search" action="{{ route('admin.membershow') }}" method="get">
                    <table class="member-table">
                        <tr>
                            <td class="member-table-left">ID</td>
                            <td class="member-table-right"><input type="text" name="id" value="{{ $id ?? '' }}"></td>
                        </tr>
                        <tr>
                            <td class="member-table-left">性別</td>
                            <td class="member-table-right">
                                <div class="form-inline">
                                    <label><input type="checkbox" name="male" value="1" {{ !empty($male)? 'checked': '' }} >男性</label>
                                </div>
                                <div class="form-inline">
                                    <label><input type="checkbox" name="female" value="2" {{ !empty($female)? 'checked': '' }} >女性</label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="member-table-left">フリーワード</td>
                            <td class="member-table-right"><input type="text" name="freeword" value="{{ $freeword ?? '' }}"></td>
                        </tr>
                    </table>
                    <div class="btn-wrapper">
                        <input class="btn btn-back-blue" type="submit" value="検索する">
                    </div>
                </form>
            </div>
        </div>





        <div class="container-member-list">
            <div class="member-show-container">
                <table class="member-showtable">
                    <tr class="member-showtable-header">
                        <th>
                            ID
                            <button name="id_flg" value="{{ $id_flg ?? 'asc' }}" class="submit-order" type="submit" form="member-search">▼</button>
                        </th>
                        <th>氏名</th>
                        <th>メールアドレス</th>
                        <th>性別</th>
                        <th>
                            登録日時
                            <button name="created_at_flg" value="{{ $created_at_flg ?? 'asc' }}" class="submit-order" type="submit" form="member-search">▼</button>
                        </th>
                        <th>編集</th>
                        <th>詳細</th>
                    </tr>
                    @if(!empty($members))
                        @foreach($members as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td>
                                    <a href="{{ route('admin.membereditshow', ['member_id'=> $member->id]) }}">
                                        {{ $member->name_sei }}　{{ $member->name_mei }}
                                    </a>
                                </td>
                                <td>{{ $member->email }}</td>
                                <td>
                                    @if($member->gender == "1")
                                        男性
                                    @else
                                        女性
                                    @endif
                                </td>
                                <td>{{ $member->created_at->format('Y/m/d') }}</td>
                                <td><a href="{{ route('admin.membereditshow', ['member_id'=> $member->id]) }}">編集</a></td>
                                <td><a href="{{ route('admin.memberdetailshow', ['member_id' => $member->id]) }}">詳細</a></td>
                            </tr>
                        @endforeach
                    @endif


                </table>
            </div>

        </div>

{{--        <div class="pagination">--}}
{{--            {{ $members->links() }}--}}
{{--        </div>--}}
        @if(!empty($id) || !empty($male) || !empty($female) || !empty($freeword) || !empty($id_flg) || !empty($created_at_flg))
            <?php
            if(!empty($id_flg)) {
                if($id_flg == 'desc') {
                    $id_flg = 'asc';
                } elseif ($id_flg == 'asc') {
                    $id_flg = 'desc';
                }
            }
            if(!empty($created_at_flg)) {
                if($created_at_flg == 'desc') {
                    $created_at_flg = 'asc';
                } elseif ($created_at_flg == 'asc') {
                    $created_at_flg = 'desc';
                }
            }
            ?>
            {{ $members->appends([
                        'id' => $id,
                        'male' => $male,
                        'female' => $female,
                        'freeword' => $freeword,
                        'id_flg' => $id_flg,
                        'created_at_flg' => $created_at_flg,
                    ])->links() }}
        @else
            <div class="pagination">
                {{ $members->links() }}
            </div>
        @endif


    </main>

    <script>
        $(function () {
            $('form').submit(function () {
                $(this).find(':submit').prop('disabled', 'true');
            });
        })
    </script>

@endsection
