@extends('layouts.app')
<?php
//dd(session()->all());

?>
@if(!empty($edit_flg))
    @section('title', '商品編集')

@else
    @section('title', '商品登録')

@endif

@section('content')

    <header class="admin-header">
        <div class="header-left">

        </div>
        <div class="header-right">

            <ul>

                {{--            <li><a class="btn btn-header" href="">商品一覧</a></li>--}}
                <?php if(empty(session('admin_login_date'))): ?>
                <li style="border: solid 1px #000"><a class="btn btn-admin-header" href="">ログイン</a></li>
                <?php endif ?>

                <?php if(!empty(session('admin_login_date'))): ?>
                <form method="post" action="">
                    @csrf
                    <li><button style="background-color: #cfcfcf; font-size: 16px; height: 32px; vertical-align: center; line-height: 16px" type="submit" class="btn btn-header">ログアウト</button></li>
                </form>
                <?php endif ?>
            </ul>
        </div>
    </header>


    <main class="admin-main">
        <div class="container admin-container">
            @if(!empty($edit_flg))
                <h2>商品編集</h2>
            @else
                <h2>商品登録</h2>
            @endif

                @if(!empty($edit_flg))
                    <form method="post" action="{{ route('admin.producteditstore') }}" enctype="multipart/form-data">
                @else
                    <form method="post" action="{{ route('admin.productregisterstore') }}" enctype="multipart/form-data">
                @endif
                @csrf
                @if(!empty($edit_flg))
                    <input type="hidden" name="product_id" value="{{$product_id}}">
                    <input type="hidden" name="member_id" value="{{ $member_id }}">
                @endif
                <input type="hidden" name="member_id" value="{{ $member_id }}">
                <input type="hidden" name="product_category_id" value="{{ $product_category_id }}">
                <input type="hidden" name="product_subcategory_id" value="{{ $product_subcategory_id }}">
                <input type="hidden" name="name" value="{{ $name }}">
                <input type="hidden" name="image_1" value="{{ $image_1 }}">
                <input type="hidden" name="image_2" value="{{ $image_2 }}">
                <input type="hidden" name="image_3" value="{{ $image_3 }}">
                <input type="hidden" name="image_4" value="{{ $image_4 }}">
                <input type="hidden" name="product_content" value="{{ $product_content }}">

                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">商品ID</lavel>
                    @if(!empty($edit_flg))
                        <span>{{ $product_id }}</span>
                    @else
                        <span>自動採番</span>
                    @endif
                </div>
                <div class="form-group">
                    <lavel style="width: 115px; display: inline-block">商品名</lavel>
                    <span>{{ $name }}</span>
                </div>

                <div class="form-group">
                    商品カテゴリ
                    <div class="form-inline">
                        @foreach($product_categories as $product_category)
                            @if($product_category->id == $product_category_id)
                                <p>{{ $product_category->name }} ＞
                                    @endif
                                    @endforeach
                                    {{--                        小カテゴリーをjQueryで生成--}}
                                    @foreach($product_subcategories as $product_subcategory)
                                        @if($product_subcategory->id == $product_subcategory_id)
                                            {{ $product_subcategory->name }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>


                <div class="form-group">
                    <span style="width: 115px; display: inline-block">商品写真</span>
                    <span>写真１</span>
                    <div style="text-align: center">
                        <div class="preview-image-wrapper">
                            <img class="js-preview1 upload-image" src="{{ !empty($image_1) ? "/uploads/".$image_1: '' }}">
                        </div>
                        <input type="hidden" name="image_1" value="{{ $image_1 }}">
                    </div>
                </div>

                <div class="form-group">
                    <span>写真2</span>
                    <div style="text-align: center">
                        <div class="preview-image-wrapper">
                            <img class="js-preview1 upload-image" src="{{ !empty($image_2) ? "/uploads/".$image_2: '' }}">
                        </div>
                        <input type="hidden" name="image_2" value="{{ $image_2 }}">
                    </div>
                </div>
                <div class="form-group">
                    <span>写真3</span>
                    <div style="text-align: center">

                        <div class="preview-image-wrapper">
                            <img class="js-preview1 upload-image" src="{{ !empty($image_3) ? "/uploads/".$image_3: '' }}">
                        </div>
                        <input type="hidden" name="image_3" value="{{ $image_3 }}">
                    </div>
                </div>
                <div class="form-group">
                    <span>写真4</span>
                    <div style="text-align: center">
                        <div class="js-image1-error-target err-msg">
                        </div>
                        <div class="preview-image-wrapper">
                            <img class="js-preview1 upload-image" src="{{ !empty($image_4) ? "/uploads/".$image_4: '' }}">
                        </div>
                        <input type="hidden" name="image_4" value="{{ $image_4 }}">
                    </div>
                </div>
                <div class="form-group" style="display: flex; padding-top: 20px">
                    <div style="width: 115px; display: inline-block">商品説明</div>
                    <div style="width: 260px;">
                        {!! nl2br(e($product_content)) !!}
                        {{--                        {{ $product->product_content }}--}}
                    </div>


            </form>

                            <div class="form-group btn-wrapper">
                                @if(!empty($edit_flg))
                                    <input class="btn btn-back-blue" type="submit" value="編集完了">
                                @else
                                    <input class="btn btn-back-blue" type="submit" value="登録完了">
                                @endif

                                @if(!empty($edit_flg))
                                    <form method="post" action="{{ route('admin.editFormre') }}" id="resend">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product_id}}">
                                        <input type="hidden" name="member_id" value="{{ $member_id }}">
                                        <input type="hidden" name="product_category_id" value="{{ $product_category_id }}">
                                        <input type="hidden" name="product_subcategory_id" value="{{ $product_subcategory_id }}">
                                        <input type="hidden" name="name" value="{{ $name }}">
                                        <input type="hidden" name="image_1" value="{{ $image_1 }}">
                                        <input type="hidden" name="image_2" value="{{ $image_2 }}">
                                        <input type="hidden" name="image_3" value="{{ $image_3 }}">
                                        <input type="hidden" name="image_4" value="{{ $image_4 }}">
                                        <input type="hidden" name="product_content" value="{{ $product_content }}">
                                    </form>
                                @else
                                    <form method="post" action="{{ route('admin.registFormre') }}" id="resend">
                                        @csrf
                                        <input type="hidden" name="member_id" value="{{ $member_id }}">
                                        <input type="hidden" name="product_category_id" value="{{ $product_category_id }}">
                                        <input type="hidden" name="product_subcategory_id" value="{{ $product_subcategory_id }}">
                                        <input type="hidden" name="name" value="{{ $name }}">
                                        <input type="hidden" name="image_1" value="{{ $image_1 }}">
                                        <input type="hidden" name="image_2" value="{{ $image_2 }}">
                                        <input type="hidden" name="image_3" value="{{ $image_3 }}">
                                        <input type="hidden" name="image_4" value="{{ $image_4 }}">
                                        <input type="hidden" name="product_content" value="{{ $product_content }}">
                                    </form>
                                    <input class="btn btn-back-blue" type="submit" value="前に戻る" form="resend">


                                @endif
                                    <button onclick="location.href='{{ url()->previous() }}'">
                                        back
                                    </button>
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
                        $('#js-ajax-target-field').append('<option value='+category.id+'>'+category.name+'</option>')
                    });
                })
            })

            // 画像を上げた瞬間にajaxでその画像をlaravel側にアップロードし、そのパスを取ってくる
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            {{--$('.js-image-uploader1').on('change', function (e) {--}}
            {{--    var file = this.files[0];--}}
            {{--    //フォームデータにアップロードファイルの情報追加--}}
            {{--    var form = new FormData();--}}
            {{--    //フォームデータにアップロードファイルの情報追加--}}
            {{--    form.append("image_1", file);--}}
            {{--    $.ajax({--}}
            {{--        url: '{{ route('admin.registImage') }}',--}}
            {{--        cache: false,--}}
            {{--        type: 'POST',--}}
            {{--        dataType: "json",--}}
            {{--        processData: false,--}}
            {{--        contentType: false,--}}
            {{--        data: form,--}}
            {{--        // コントローラから受け取ったデータ(検索結果)をdataに代入し以下の処理を実行します--}}
            {{--    }).done((data) => {--}}
            {{--        $('.js-preview1').attr('src', '/uploads/'+data['returnFileName1']);--}}
            {{--        $('.js-image-path-hidden1').attr('value', data['returnFileName1']);--}}
            {{--    }).fail((error) => {--}}
            {{--        console.log(error.statusText)--}}
            {{--        if(error.statusText == 'Payload Too Large') {--}}
            {{--            console.log(error.statusText)--}}
            {{--            // $('').append('<p>'+error.statusText+'</p>');--}}
            {{--            $('.js-image1-error-target').append('<p>ファイルのサイズが大きすぎます。10MB以下にしてください</p>')--}}
            {{--        }--}}
            {{--        if(error.statusText == 'Unprocessable Entity') {--}}
            {{--            console.log(error.statusText);--}}
            {{--            $('.js-image1-error-target').append('<p>１０MBまでのjpg、jpeg、png、gifのファイルのみアップロード可能です</p>')--}}
            {{--        }--}}
            {{--    })--}}
            {{--});--}}

            {{--$('.js-image-uploader2').on('change', function (e) {--}}
            {{--    var file = this.files[0];--}}
            {{--    //フォームデータにアップロードファイルの情報追加--}}
            {{--    var form = new FormData();--}}
            {{--    //フォームデータにアップロードファイルの情報追加--}}
            {{--    form.append("image_2", file);--}}
            {{--    $.ajax({--}}
            {{--        url: '{{ route('admin.registImage') }}',--}}
            {{--        type: 'POST',--}}
            {{--        headers: {--}}
            {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--        },--}}
            {{--        processData: false,--}}
            {{--        contentType: false,--}}
            {{--        data: form,--}}
            {{--        // コントローラから受け取ったデータ(検索結果)をdataに代入し以下の処理を実行します--}}
            {{--    }).done((data) => {--}}
            {{--        // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します--}}
            {{--        // console.log(data);--}}
            {{--        $('.js-preview2').attr('src', '/uploads/'+data['returnFileName2']);--}}
            {{--        $('.js-image-path-hidden2').attr('value', data['returnFileName2']);--}}
            {{--    }).fail((error) => {--}}
            {{--        if(error.statusText == 'Payload Too Large') {--}}
            {{--            console.log(error.statusText)--}}
            {{--            // $('').append('<p>'+error.statusText+'</p>');--}}
            {{--            $('.js-image1-error-target').append('<p>ファイルのサイズが大きすぎます。10MB以下にしてください</p>')--}}
            {{--        }--}}
            {{--        if(error.statusText == 'Unprocessable Entity') {--}}
            {{--            console.log(error.statusText);--}}
            {{--            $('.js-image1-error-target').append('<p>１０MBまでのjpg、jpeg、png、gifのファイルのみアップロード可能です</p>')--}}
            {{--        }--}}
            {{--    })--}}
            {{--});--}}


            {{--$('.js-image-uploader3').on('change', function (e) {--}}
            {{--    var file = this.files[0];--}}
            {{--    //フォームデータにアップロードファイルの情報追加--}}
            {{--    var form = new FormData();--}}
            {{--    //フォームデータにアップロードファイルの情報追加--}}
            {{--    form.append("image_3", file);--}}
            {{--    $.ajax({--}}
            {{--        url: '{{ route('admin.registImage') }}',--}}
            {{--        type: 'POST',--}}
            {{--        headers: {--}}
            {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--        },--}}
            {{--        processData: false,--}}
            {{--        contentType: false,--}}
            {{--        data: form,--}}
            {{--        // コントローラから受け取ったデータ(検索結果)をdataに代入し以下の処理を実行します--}}
            {{--    }).done((data) => {--}}
            {{--        // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します--}}
            {{--        // console.log(data);--}}
            {{--        $('.js-preview3').attr('src', '/uploads/'+data['returnFileName3']);--}}
            {{--        $('.js-image-path-hidden3').attr('value', data['returnFileName3']);--}}
            {{--    }).fail((error) => {--}}
            {{--        if(error.statusText == 'Payload Too Large') {--}}
            {{--            console.log(error.statusText)--}}
            {{--            // $('').append('<p>'+error.statusText+'</p>');--}}
            {{--            $('.js-image1-error-target').append('<p>ファイルのサイズが大きすぎます。10MB以下にしてください</p>')--}}
            {{--        }--}}
            {{--        if(error.statusText == 'Unprocessable Entity') {--}}
            {{--            console.log(error.statusText);--}}
            {{--            $('.js-image1-error-target').append('<p>１０MBまでのjpg、jpeg、png、gifのファイルのみアップロード可能です</p>')--}}
            {{--        }--}}
            {{--    })--}}
            {{--});--}}

            {{--$('.js-image-uploader4').on('change', function (e) {--}}
            {{--    var file = this.files[0];--}}
            {{--    //フォームデータにアップロードファイルの情報追加--}}
            {{--    var form = new FormData();--}}
            {{--    //フォームデータにアップロードファイルの情報追加--}}
            {{--    form.append("image_4", file);--}}
            {{--    $.ajax({--}}
            {{--        url: '{{ route('admin.registImage') }}',--}}
            {{--        type: 'POST',--}}
            {{--        headers: {--}}
            {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--        },--}}
            {{--        processData: false,--}}
            {{--        contentType: false,--}}
            {{--        data: form,--}}
            {{--        // コントローラから受け取ったデータ(検索結果)をdataに代入し以下の処理を実行します--}}
            {{--    }).done((data) => {--}}
            {{--        // 受け取ったデータ(検索結果)を仕入れ先のvalueに反映します--}}
            {{--        // console.log(data);--}}
            {{--        $('.js-preview4').attr('src', '/uploads/'+data['returnFileName4']);--}}
            {{--        $('.js-image-path-hidden4').attr('value', data['returnFileName4']);--}}
            {{--    }).fail((error) => {--}}
            {{--        if(error.statusText == 'Payload Too Large') {--}}
            {{--            console.log(error.statusText)--}}
            {{--            // $('').append('<p>'+error.statusText+'</p>');--}}
            {{--            $('.js-image1-error-target').append('<p>ファイルのサイズが大きすぎます。10MB以下にしてください</p>')--}}
            {{--        }--}}
            {{--        if(error.statusText == 'Unprocessable Entity') {--}}
            {{--            console.log(error.statusText);--}}
            {{--            $('.js-image1-error-target').append('<p>１０MBまでのjpg、jpeg、png、gifのファイルのみアップロード可能です</p>')--}}
            {{--        }--}}
            {{--    })--}}
            {{--});--}}

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
