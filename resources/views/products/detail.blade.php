@extends('layouts.app')
<?php
//dd($return_product_category_id);
//dd($products);
?>

@section('title', '商品詳細')
@section('content')
    <header class="header">
        <div class="header-left">
            <h2 style="height: 60px; line-height: 60px;">商品詳細</h2>
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



            <div class="form-group">
                <div class="form-inline">
                    @foreach($product_categories as $product_category)
                        @if($product_category->id == $product->product_category_id)
                            <p>{{ $product_category->name }} ＞
                                @endif
                                @endforeach
                                {{--                        小カテゴリーをjQueryで生成--}}
                                @foreach($product_subcategories as $product_subcategory)
                                    @if($product_subcategory->id == $product->product_subcategory_id)
                                        {{ $product_subcategory->name }}</p>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <div>
                    <h2 style="text-align: left; display: inline; font-size: 20px">{{ $product->name }}</h2>
                    <p style="display: inline">　　　　　更新日時：{{ $product->updated_at->format('Ymd') }}</p>
                </div>
            </div>

            <div class="detail-image-area">
                <div class="detail-image-wrapper">
                    <img src="{{ !empty($product->image_1) ? "/uploads/".$product->image_1: '' }}" alt="">
                </div>
                <div class="detail-image-wrapper">
                    <img src="{{ !empty($product->image_2) ? "/uploads/".$product->image_2: '' }}" alt="">
                </div>
                <div class="detail-image-wrapper">
                    <img src="{{ !empty($product->image_3) ? "/uploads/".$product->image_3: '' }}" alt="">
                </div>
                <div class="detail-image-wrapper">
                    <img src="{{ !empty($product->image_4) ? "/uploads/".$product->image_4: '' }}" alt="">
                </div>
            </div>


            <div class="form-group" style="padding-top: 20px">
                <div>■商品説明</div>
                <div style="margin-top: 10px">
                    {!! nl2br(e($product->product_content)) !!}
{{--                    {{ $product->product_content }}--}}
                </div>
            </div>

            <div class="form-group" style="padding-top: 20px">
                <div>■商品レビュー</div>
                <div style="margin-top: 10px">
                    総合評価　
                    {{--                    塗りつぶし用 <i class="fas fa-star"></i>--}}
                    {{--                    空欄用 <i class="far fa-star"></i>--}}
                    {{--                    半分 <i class="fas fa-star-half-alt"></i>--}}


                    @if(!empty($average))
                        @if((ceil($average) == 0))
                            <i class="far fa-star"></i>
                        @elseif(ceil($average) == 1)
                            <i class="fas fa-star"></i>
                        @elseif((ceil($average) == 2))
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        @elseif((ceil($average) == 3))
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        @elseif((ceil($average) == 4))
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        @elseif((ceil($average) == 5))
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        @endif
                        {{ ceil($average) }}
                    @else
                        レビュー無し
                    @endif
                </div>
                <div style="margin-top: 10px">
                    <a style="color: #406bca" href="{{ route('products.reviewshow', ['product_id' => $product->id]) }}">＞＞レビューを見る</a>
                </div>
            </div>

            <div style="text-align: right">
                <div class="inline">
                    <div class="btn-wrapper-detail">
                        <?php if(!empty(session('login_date'))): ?>
                        <a class="btn btn-back-blue" href="{{ route('products.reviewregist', ['id' => $product->id]) }}" >この商品についてのレビューを登録</a>
                        <?php endif; ?>


                    </div>
                    <div class="btn-wrapper-detail">
                        <button class="btn btn-back-blue" type="button" onclick="history.back()">商品一覧に戻る</button>
                    </div>
                </div>
            </div>


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
        })
    </script>
@endsection


