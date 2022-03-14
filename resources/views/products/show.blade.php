@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
?>

@section('title', '商品一覧')
@section('content')
    <header class="header">
        <div class="header-left">
            <h2 style="height: 60px; line-height: 60px;">商品一覧</h2>
        </div>
        <div class="header-right">
            <ul>
                <?php if(!empty(session('login_date'))): ?>
                <li><a class="btn btn-header" href="{{ route('products.registForm') }}">新規商品登録</a></li>
                <?php endif ?>
            </ul>
        </div>
    </header>
    <main>
        <div class="container bg-color_white">

            <form method="get" action="{{ route('products.search') }}">

                <div class="form-group">
                    カテゴリ
                    <div class="form-inline">
                        <lavel for=""></lavel>
                        <select name="product_category_id" id="js-ajax-change-subcategories">
                            <option value="0">カテゴリ</option>
                            @if(!empty($product_categories))
                                @foreach($product_categories as $product_category)
                                    @if(!empty($return_product_caegory_id))
                                        <option value="{{ $product_category->id }}" {{ ( $return_product_caegory_id == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                    @else
                                        <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-inline">
                        <lavel for=""></lavel>
                        {{--                        小カテゴリーをjQueryで生成--}}
                        <select required name="product_subcategory_id" id="js-ajax-target-field">
                            <option value="0">サブカテゴリ</option>
                            @if(!empty($return_product_subcaegory_id))
                                @foreach($product_subcategories as $product_subcategory)
                                        <option value="{{ $product_subcategory->id }}" {{ ( $return_product_subcaegory_id == $product_subcategory->id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">フリーワード</lavel>
                    @if(!empty($return_freeword))
                        <input style="width: 260px;" type="text" name="freeword" value="{{ $return_freeword }}">
                    @else
                        <input style="width: 260px;" type="text" name="freeword">
                    @endif
                </div>

                <div class="form-group" style="text-align: center">
                    <input class="search-btn" type="submit" value="商品検索">
                </div>

            </form>
        </div>

        <div style="margin: 20px"></div>
        <div class="container" style="border: none; width: 700px; box-sizing: border-box; padding: 0">
            @foreach($products as $product)
            <div class="product-card">
                <div class="product-card-left">
                    <img src="{{ !empty($product->image_1) ? "/uploads/".$product->image_1: '' }}" alt="">
                </div>
                <div class="product-card-right">
                    <div class="category-area">
                        <p style="background-color: #fff; display: inline; padding: 0 10px">
                            {{ \App\Product::showProductCategoryName($product->product_category_id) }} > {{ \App\Product::showProductSubCategoryName($product->product_subcategory_id) }}
                        </p>
                    </div>
                    <div class="name-area">
                        {{ $product->name }}
                    </div>
                    <div class="form-group btn-wrapper" style="text-align: right">
                        <a class="btn btn-back" style="border: 1px solid #406bca; background-color: #406bca;color: #fff" href="{{ route('products.detail', ['id' => $product->id]) }}" >詳細</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if(!empty($return_product_category_id) || !empty($return_product_subcategory_id) || !empty($freeword))
        <div class="pagination">
            {{ $products->appends(['product_category_id' => $return_product_category_id,'product_subcategory_id' => $return_product_subcategory_id,'freeword' => $return_freeword])->links() }}
        </div>
        @else
            <div class="pagination">
                {{ $products->links() }}
            </div>
        @endif


        <div class="form-group btn-wrapper">
            <a class="btn btn-back" style="border: 1px solid #406bca; color: #406bca" href="{{ route('index') }}" >トップに戻る</a>
        </div>
    </main>
    <script>
        $(function() {
            // 大カテゴリが選択されたら、そのIDから小カテゴリを取ってくる
            $('#js-ajax-change-subcategories').change(function() {
                $('#js-ajax-target-field').empty();
                let categoryid = $(this).val();
                console.log(categoryid);
                $.ajax({
                    url: '/products/regist/getsubcategory/'+categoryid,
                    type: 'GET',
                    // コントローラから受け取ったデータ(検索結果)をdataに代入
                }).done((data) => {
                    console.log(data.product_subcategories);
                    $('#js-ajax-target-field').append('<option value="0">サブカテゴリ</option>')
                    $(data.product_subcategories).each((index, category) => {
                        console.log(category)
                        $('#js-ajax-target-field').append('<option value='+category.id+'>'+category.name+'</option>')
                    });
                })
            })

            // 画像を上げた瞬間にajaxでその画像をlaravel側にアップロードし、そのパスを取ってくる
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.js-image-uploader1').on('change', function (e) {
                var file = this.files[0];
                //フォームデータにアップロードファイルの情報追加
                var form = new FormData();
                //フォームデータにアップロードファイルの情報追加
                form.append("image_1", file);
                $.ajax({
                    url: '{{ route('products.registImage') }}',
                    cache: false,
                    type: 'POST',
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: form,
                    // コントローラから受け取ったデータ(検索結果)をdataに代入し以下の処理を実行します
                }).done((data) => {
                    $('.js-preview1').attr('src', '/uploads/'+data['returnFileName1']);
                    $('.js-image-path-hidden1').attr('value', data['returnFileName1']);
                }).fail((error) => {
                    console.log(error.statusText)
                    if(error.statusText == 'Payload Too Large') {
                        console.log(error.statusText)
                        // $('').append('<p>'+error.statusText+'</p>');
                        $('.js-image1-error-target').append('<p>ファイルのサイズが大きすぎます</p>')
                    }
                })
            });

            $('.js-image-uploader2').on('change', function (e) {
                var file = this.files[0];
                //フォームデータにアップロードファイルの情報追加
                var form = new FormData();
                //フォームデータにアップロードファイルの情報追加
                form.append("image_2", file);
                $.ajax({
                    url: '/products/regist/productimage',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    data: form,
                    // コントローラから受け取ったデータ(検索結果)をdataに代入し以下の処理を実行します
                }).done((data) => {
                    // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します
                    // console.log(data);
                    $('.js-preview2').attr('src', '/uploads/'+data['returnFileName2']);
                    $('.js-image-path-hidden2').attr('value', data['returnFileName2']);
                }).fail((error) => {
                    if(error.statusText == 'Payload Too Large') {
                        $('.js-image2-error-target').append('<p>ファイルのサイズが大きすぎます</p>')
                    }
                })
            });


            $('.js-image-uploader3').on('change', function (e) {
                var file = this.files[0];
                //フォームデータにアップロードファイルの情報追加
                var form = new FormData();
                //フォームデータにアップロードファイルの情報追加
                form.append("image_3", file);
                $.ajax({
                    url: '/products/regist/productimage',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    data: form,
                    // コントローラから受け取ったデータ(検索結果)をdataに代入し以下の処理を実行します
                }).done((data) => {
                    // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します
                    // console.log(data);
                    $('.js-preview3').attr('src', '/uploads/'+data['returnFileName3']);
                    $('.js-image-path-hidden3').attr('value', data['returnFileName3']);
                }).fail((error) => {
                    if(error.statusText == 'Payload Too Large') {
                        $('.js-image3-error-target').append('<p>ファイルのサイズが大きすぎます</p>')
                    }
                })
            });

            $('.js-image-uploader4').on('change', function (e) {
                var file = this.files[0];
                //フォームデータにアップロードファイルの情報追加
                var form = new FormData();
                //フォームデータにアップロードファイルの情報追加
                form.append("image_4", file);
                $.ajax({
                    url: '/products/regist/productimage',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    contentType: false,
                    data: form,
                    // コントローラから受け取ったデータ(検索結果)をdataに代入し以下の処理を実行します
                }).done((data) => {
                    // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します
                    // console.log(data);
                    $('.js-preview4').attr('src', '/uploads/'+data['returnFileName4']);
                    $('.js-image-path-hidden4').attr('value', data['returnFileName4']);
                }).fail((error) => {
                    if(error.statusText == 'Payload Too Large') {
                        $('.js-image4-error-target').append('<p>ファイルのサイズが大きすぎます</p>')
                    }
                })
            });

            // 画像ファイルにあげ、それをそのまま表示
            // $('.js-image-uploader1').on('change', function (e) {
            //     console.log('this');
            //     let reader = new FileReader();
            //     reader.onload = function (e) {
            //         $('.js-preview1').attr('src', e.target.result)
            //     }
            //     reader.readAsDataURL(e.target.files[0]);
            // });
            // $('.js-image-uploader2').on('change', function (e) {
            //     let reader = new FileReader();
            //     reader.onload = function (e) {
            //         $('.js-preview2').attr('src', e.target.result)
            //     }
            //     reader.readAsDataURL(e.target.files[0]);
            // });
            // $('.js-image-uploader3').on('change', function (e) {
            //     let reader = new FileReader();
            //     reader.onload = function (e) {
            //         $('.js-preview3').attr('src', e.target.result)
            //     }
            //     reader.readAsDataURL(e.target.files[0]);
            // });
            // $('.js-image-uploader4').on('change', function (e) {
            //     let reader = new FileReader();
            //     reader.onload = function (e) {
            //         $('.js-preview4').attr('src', e.target.result)
            //     }
            //     reader.readAsDataURL(e.target.files[0]);
            // });

            $('form').submit(function () {
                $(this).find(':submit').prop('disabled', 'true');
            });

            $('')

        })
    </script>
@endsection


