@extends('layouts.app')
<?php
//dd(session()->all());

?>

@section('title', '新規商品登録')
@section('content')
    @include('layouts.nav')
    <main>
        <div class="container">
            <h2>商品登録</h2>
            <form method="post" action="{{ route('products.productStore') }}" enctype="multipart/form-data">
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
                    <input style="width: 260px;" type="text" name="name" required value="{{old('name')}}">
                </div>

                <div class="form-group">
                    商品カテゴリ
                    <div class="form-inline">
                        <lavel for=""></lavel>
                        <select name="product_category_id" id="js-ajax-change-subcategories" required>
                            <option value="0">選択してください</option>
                            @if(!empty($product_categories))
                                @foreach($product_categories as $product_category)
                                    <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-inline">
                        <lavel for=""></lavel>
{{--                        小カテゴリーをjQueryで生成--}}
                        <select required name="product_subcategory_id" id="js-ajax-target-field">

                        </select>
                    </div>

                    <div class="form-group">
                        <span style="width: 115px; display: inline-block">商品写真</span>
                        <span>写真１</span>
                        <div style="text-align: center">
                            <div class="preview-image-wrapper">
                                <img class="js-preview1 upload-image" src="">
                            </div>
                            <label class="btn btn-back" for="image_1">アップロード
                                <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                <input class="js-image-path-hidden1" type="hidden" name="image_1">
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <span style="width: 115px; display: inline-block"></span>
                        <span>写真２</span>
                        <div style="text-align: center">

                            <div class="preview-image-wrapper">
                                <img class="js-preview2 upload-image" src="">
                            </div>
                            <label class="btn btn-back" for="image_2">アップロード
                                <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                <input class="js-image-path-hidden2" type="hidden" name="image_2">
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <span style="width: 115px; display: inline-block"></span>
                        <span>写真３</span>
                        <div style="text-align: center">

                            <div class="preview-image-wrapper">
                                <img class="js-preview3 upload-image" src="">
                            </div>
                            <label class="btn btn-back" for="image_3">アップロード
                                <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                <input class="js-image-path-hidden3" type="hidden" name="image_3">
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <span style="width: 115px; display: inline-block"></span>
                        <span>写真４</span>
                        <div style="text-align: center">

                            <div class="preview-image-wrapper">
                                <img class="js-preview4 upload-image" src="">
                            </div>
                            <label class="btn btn-back" for="image_4">アップロード
                                <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                <input class="js-image-path-hidden4" type="hidden" name="image_4">
                            </label>
                        </div>
                    </div>

                <div class="form-group" style="display: flex; padding-top: 20px">
                    <div style="width: 115px; display: inline-block">商品説明</div>
                    <div style="width: 260px;">
                        <textarea style="width: 260px;" type="text" name="product_content" required value="{{old('product_content')}}"></textarea>
                    </div>
                </div>
                <div class="err-msg">

                </div>

                <div class="form-group btn-wrapper">
                    <input class="btn btn-default" type="submit" value="確認画面へ">
                </div>
                <div class="form-group btn-wrapper">
                    <a class="btn btn-back" href="{{ route('index') }}" >トップに戻る</a>
                </div>
            </form>
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
                    success: function(data) {
                        console.log(data.product_subcategories);
                        $('#js-ajax-target-field').append('<option value="0">選択してください</option>')
                        $(data.product_subcategories).each((index, category) => {
                            console.log(category)
                            $('#js-ajax-target-field').append('<option value='+category.id+'>'+category.name+'</option>')
                        });

                    }
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
                    type: 'POST',
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: form,
                    // コントローラから受け取ったデータ(検索結果)をdataに代入し以下の処理を実行します
                    success: function(data) {
                        // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します
                        // console.log(data);
                        $('.js-preview1').attr('src', '/uploads/'+data['returnFileName1']);
                        $('.js-image-path-hidden1').attr('value', data['returnFileName1']);
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
                    success: function(data) {
                        // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します
                        // console.log(data);
                        $('.js-preview2').attr('src', '/uploads/'+data['returnFileName2']);
                        $('.js-image-path-hidden2').attr('value', data['returnFileName2']);
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
                    success: function(data) {
                        // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します
                        // console.log(data);
                        $('.js-preview3').attr('src', '/uploads/'+data['returnFileName3']);
                        $('.js-image-path-hidden3').attr('value', data['returnFileName3']);
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
                    success: function(data) {
                        // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します
                        // console.log(data);
                        $('.js-preview4').attr('src', '/uploads/'+data['returnFileName4']);
                        $('.js-image-path-hidden4').attr('value', data['returnFileName4']);
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

        })
    </script>
@endsection


