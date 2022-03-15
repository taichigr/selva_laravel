@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
//    dd(session()->all());
//    dd($members);
//    dd($product_categories);
?>

@section('title', '商品レビュー一覧')
@section('content')
    <header class="admin-header">
        <div class="header-left">
            <h1>商品レビュー一覧</h1>

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
                <?php if(empty(session('admin_login_date'))): ?>
                <li><a class="btn btn-admin-header" href="{{ route('admin.index') }}">トップへ戻る</a></li>
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
            <div class="btn-wrapper" style="text-align: left; margin-bottom: 30px">
                <a class="btn btn-default-blue" href="{{ route('admin.productreviewregister') }}">商品レビュー登録</a>
            </div>

            {{--            <div class="form-group">--}}
            {{--                <div class="btn-wrapper" style="text-align: left">--}}
            {{--                    <a class="btn btn-default-blue" href="">会員登録</a>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <div class="member-form-container">


                <form id="product_review-search" action="{{ route('admin.productreviewshow') }}" method="get">
                    <table class="member-table">
                        <tr>
                            <td class="member-table-left">ID</td>
                            <td class="member-table-right"><input type="text" name="review_id" value="{{ $review_id ?? '' }}"></td>
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
                            <button name="id_flg" value="{{ $id_flg ?? 'asc' }}" class="submit-order" type="submit" form="product_review-search">▼</button>
                        </th>
                        <th>商品ID</th>
                        <th>評価</th>
                        <th>商品コメント</th>
                        <th>
                            登録日時
                            <button name="created_at_flg" value="{{ $created_at_flg ?? 'asc' }}" class="submit-order" type="submit" form="product_review-search">▼</button>
                        </th>
                        <th>編集</th>
                        <th>詳細</th>
                    </tr>
                    @if(!empty($reviews))
                        @foreach($reviews as $review)
                            <tr style="background-color: #fff">
                                <td>{{ $review->id }}</td>
                                <td>{{ $review->product_id }}</td>
                                <td>{{ $review->evaluation }}</td>
                                <td>
                                    <a href="{{ route('admin.productreviewdetail', ['review_id' => $review->id]) }}">
                                        @if(mb_strlen($review->comment) >= 7)
                                            {{ mb_substr($review->comment,0,7) }}...
                                        @else
                                            {{ $review->comment }}
                                        @endif
                                    </a>
                                </td>


                                <td>{{ $review->created_at->format('Y/m/d') }}</td>
                                <td><a href="{{ route('admin.productreviewedit', ['review_id' => $review->id]) }}">編集</a></td>
                                <td><a href="{{ route('admin.productreviewdetail', ['review_id' => $review->id]) }}">詳細</a></td>
                            </tr>
                        @endforeach
                    @endif


                </table>
            </div>

        </div>


        @if(!empty($review_id)||!empty($freeword)||!empty($id_flg)||!empty($created_at_flg))
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
            <div class="pagination">
                {{ $reviews->appends([
                    '$reviews' => $reviews,
                    'freeword' => $freeword,
                    'id_flg' => $id_flg,
                    'created_at_flg' => $created_at_flg])->links() }}
            </div>


        @else
            <div class="pagination">
                {{ $reviews->links() }}
            </div>

        @endif


    </main>

    <script>
        // $(function () {
        //     $('form').submit(function () {
        //         $(this).find(':submit').prop('disabled', 'true');
        //     });
        // })
    </script>

@endsection
