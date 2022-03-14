@extends('layouts.app')
<?php
?>

@section('title', '商品登録確認画面')
@section('content')
    @include('layouts.nav')
    <main>
        <div class="container">
            <h2>商品登録</h2>
            <form method="post" action="{{ route('products.productStore') }}">
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
                    <lavel style="width: 115px; display: inline-block">商品名</lavel>
                    <div>{{ $product->name }}</div>
                    <input style="width: 260px;" type="hidden" name="name" required value="{{ $product->name }}">
                </div>

                <div class="form-group">
                    商品カテゴリ
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
                            <input type="hidden" name="product_category_id" value="{{ $product->product_category_id }}">
                            <input type="hidden" name="product_subcategory_id" value="{{ $product->product_subcategory_id }}">
                    </div>
                </div>


                <div class="form-group">
                    <span style="width: 115px; display: inline-block">商品写真</span>
                    <span>写真１</span>
                    <div style="text-align: center">
                        <div class="preview-image-wrapper">
                            <img class="js-preview1 upload-image" src="{{ !empty($product->image_1) ? "/uploads/".$product->image_1: '' }}">
                        </div>
                        <input type="hidden" name="image_1" value="{{ $product->image_1 }}">
                    </div>
                </div>

                <div class="form-group">
                    <span>写真2</span>
                    <div style="text-align: center">
                        <div class="preview-image-wrapper">
                            <img class="js-preview1 upload-image" src="{{ !empty($product->image_2) ? "/uploads/".$product->image_2: '' }}">
                        </div>
                        <input type="hidden" name="image_2" value="{{ $product->image_2 }}">
                    </div>
                </div>
                <div class="form-group">
                    <span>写真3</span>
                    <div style="text-align: center">

                        <div class="preview-image-wrapper">
                            <img class="js-preview1 upload-image" src="{{ !empty($product->image_3) ? "/uploads/".$product->image_3: '' }}">
                        </div>
                        <input type="hidden" name="image_3" value="{{ $product->image_3 }}">
                    </div>
                </div>
                <div class="form-group">
                    <span>写真4</span>
                    <div style="text-align: center">
                        <div class="js-image1-error-target err-msg">
                        </div>
                        <div class="preview-image-wrapper">
                            <img class="js-preview1 upload-image" src="{{ !empty($product->image_4) ? "/uploads/".$product->image_4: '' }}">
                        </div>
                        <input type="hidden" name="image_4" value="{{ $product->image_4 }}">
                    </div>
                </div>
                <div class="form-group" style="display: flex; padding-top: 20px">
                    <div style="width: 115px; display: inline-block">商品説明</div>
                    <div style="width: 260px;">
                        {!! nl2br(e($product->product_content)) !!}
{{--                        {{ $product->product_content }}--}}
                    </div>
                    <input type="hidden" name="product_content" value="{{ $product->product_content }}">
                </div>
                <div class="err-msg">

                </div>

                <div class="form-group btn-wrapper">
                    <input class="btn btn-default" type="submit" value="商品を登録する">
                </div>
            </form>
            <form method="post" action="{{ route('products.registFormre') }}" id="resend">
                @csrf
                <input style="width: 260px;" type="hidden" name="name" required value="{{ $product->name }}">
                <input type="hidden" name="product_category_id" value="{{ $product->product_category_id }}">
                <input type="hidden" name="product_subcategory_id" value="{{ $product->product_subcategory_id }}">
                <input type="hidden" name="image_1" value="{{ $product->image_1 }}">
                <input type="hidden" name="image_2" value="{{ $product->image_2 }}">
                <input type="hidden" name="image_3" value="{{ $product->image_3 }}">
                <input type="hidden" name="image_4" value="{{ $product->image_4 }}">
                <input type="hidden" name="product_content" value="{{ $product->product_content }}">
            </form>
            <div class="form-group btn-wrapper">
                <input form="resend" class="btn btn-default" type="submit" value="前に戻る">
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
                    $('#js-ajax-target-field').append('<option value="0">選択してください</option>')
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


