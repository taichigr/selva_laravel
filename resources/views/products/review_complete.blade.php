@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
//    dd($product_id);
?>

@section('title', '商品レビュー登録完了')
@section('content')
    <header class="header">
        <div class="header-left">
            <h2 style="height: 60px; line-height: 60px;">商品レビュー登録完了</h2>
        </div>
        <div class="header-right">
            <ul>
                <li><a class="btn btn-header" href="{{ route('index') }}">トップに戻る</a></li>

            </ul>
        </div>
    </header>
    <main>
        <div style="margin: 20px"></div>
        <div class="container" style="width: 900px; border: none; box-sizing: border-box; padding: 20px">

            <div>
                商品レビューの登録が完了しました。
            </div>


                <div style="text-align: center">
                    <div class="inline">
                        <div class="btn-wrapper-detail">
                            <a class="btn btn-back-blue"  href="{{ route('products.reviewshow', ['product_id' => $product_id]) }}">商品レビュー一覧へ</a>
                        </div>
                        <div class="btn-wrapper-detail">
                            <a class="btn btn-default" style="color: #fff; background-color: #406bca" href="{{ route('products.detail', ['id' => $product_id]) }}" >商品詳細に戻る</a>
                        </div>
                    </div>
                </div>
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


