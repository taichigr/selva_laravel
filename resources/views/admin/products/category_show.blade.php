@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
//    dd(session()->all());
//    dd($members);
//    dd($product_categories);
?>

@section('title', '商品カテゴリー一覧')
@section('content')
    <header class="admin-header">
        <div class="header-left">
            <h1>商品カテゴリー一覧</h1>

        </div>
        <div class="header-right">

            <ul>
                {{--            <li><a class="btn btn-header" href="">商品一覧</a></li>--}}
                <?php if(empty(session('admin_login_date'))): ?>
                <li><a class="btn btn-admin-header" href="{{ route('admin.login') }}">ログイン</a></li>
                <?php endif ?>


                <?php if(!empty(session('admin_login_date'))): ?>
                    <li><a class="btn btn-admin-header" style="border: solid 1px #000" href="{{ route('admin.index') }}">トップへ戻る</a></li>
                    {{--                <form method="post" action="{{ route('admin.logout') }}">--}}
{{--                    @csrf--}}
{{--                    <li><button style="background-color: #cfcfcf; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>--}}
{{--                </form>--}}
                <?php endif ?>
            </ul>
        </div>
    </header>

    {{--    @include('layouts.admin_nav')--}}
    <main class="admin-main">
        <div class="container admin-container">
            <div class="btn-wrapper" style="text-align: left; margin-bottom: 30px">
                <a class="btn btn-default-blue" href="{{ route('admin.productscategoryregister') }}">商品カテゴリ登録</a>
            </div>

{{--            <div class="form-group">--}}
{{--                <div class="btn-wrapper" style="text-align: left">--}}
{{--                    <a class="btn btn-default-blue" href="">会員登録</a>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="member-form-container">


                <form id="product_categories-search" action="{{ route('admin.productscategoryshow') }}" method="get">
                    <table class="member-table">
                        <tr>
                            <td class="member-table-left">ID</td>
                            <td class="member-table-right"><input type="text" name="product_category_id" value="{{ $product_category_id ?? '' }}"></td>
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
                            <button name="id_flg" value="{{ $id_flg ?? 'asc' }}" class="submit-order" type="submit" form="product_categories-search">▼</button>
                        </th>
                        <th>商品大カテゴリ</th>
                        <th>
                            登録日時
                            <button name="created_at_flg" value="{{ $created_at_flg ?? 'asc' }}" class="submit-order" type="submit" form="product_categories-search">▼</button>
                        </th>
                        <th>編集</th>
                        <th>詳細</th>
                    </tr>
                    @if(!empty($product_categories))
                        @foreach($product_categories as $product_category)
                            <tr style="background-color: #fff">
                                <td>{{ $product_category->id }}</td>
                                <td>
                                    <a href="{{ route('admin.productscategorydetail', ['product_category_id' => $product_category->id]) }}">
                                        {{ $product_category->name }}
                                    </a>
                                </td>

                                <td>{{ $product_category->created_at->format('Y/m/d') }}</td>
                                <td><a href="{{ route('admin.productscategoryedit', ['product_category_id' => $product_category->id]) }}">編集</a></td>
                                <td><a href="{{ route('admin.productscategorydetail', ['product_category_id' => $product_category->id]) }}">詳細</a></td>
                            </tr>
                        @endforeach
                    @endif


                </table>
            </div>

        </div>


        @if(!empty($product_category_id)||!empty($freeword)||!empty($product_category_id)||!empty($id_flg)||!empty($created_at_flg))
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
                {{ $product_categories->appends([
                    'product_categories' => $product_categories,
                    'product_category_id' => $product_category_id,
                    'freeword' => $freeword,
                    'id_flg' => $id_flg,
                    'created_at_flg' => $created_at_flg])->links() }}
            </div>


        @else
            <div class="pagination">
                {{ $product_categories->links() }}
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
