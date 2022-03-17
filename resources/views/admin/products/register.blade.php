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
                <li><a class="btn btn-admin-header" style="border: solid 1px #000" href="{{ route('admin.productsshow') }}">一覧へ戻る</a></li>

            <?php endif ?>
            </ul>
        </div>
    </header>


    <main class="admin-main">
        <div class="container admin-container">

            @if(!empty($edit_flg))
                <h2>商品編集</h2>

                @if(!empty($resend_flg))
                    <form method="post" action="{{ route('admin.producteditcheck') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product_id}}">
                        <input type="hidden" name="member_id" value="{{ $member_id }}">
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
                            <lavel style="width: 115px; display: inline-block">商品ID</lavel>
                            <span>{{ $product_id }}</span>
                        </div>
                        <div class="form-group">
                            <lavel style="width: 115px; display: inline-block">商品名</lavel>
                            <input style="width: 260px;" type="text" name="name" required value="{{old('name') ?? $name}}">
                        </div>

                        <div class="form-group">
                            商品カテゴリ
                            <div class="form-inline">
                                <lavel for=""></lavel>
                                <select name="product_category_id" id="js-ajax-change-subcategories" required>
                                    <option value="0">選択してください</option>
                                    @if(!empty(old('product_category_id')))
                                        @if(!empty($product_categories))
                                            @foreach($product_categories as $product_category)
                                                <option value="{{ $product_category->id }}" {{ (old('product_category_id') == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                            @endforeach
                                        @endif
                                    @elseif(!empty($product_category_id))
                                        @if(!empty($product_categories))
                                            @foreach($product_categories as $product_category)
                                                <option value="{{ $product_category->id }}" {{ ($product_category_id == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                            @endforeach
                                        @endif
                                    @else
                                        @if(!empty($product_categories))
                                            @foreach($product_categories as $product_category)
                                                <option value="{{ $product_category->id }}" {{ (old('product_category_id') == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                            </div>
                            <div class="form-inline">
                                <lavel for=""></lavel>
                                {{--                        小カテゴリーをjQueryで生成--}}
                                <select required name="product_subcategory_id" id="js-ajax-target-field">
                                    @if(!empty(old('product_subcategory_id')))
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == old('product_category_id'))
                                                <option value="{{ $product_subcategory->id }}" {{ (old('product_subcategory_id') == $product->product_subcategory_id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach

                                    @elseif(!empty($product_subcategory_id))
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == $product_category_id)
                                                <option value="{{ $product_subcategory->id }}" {{ ($product_subcategory_id == $product_subcategory_id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == old('product_category_id'))
                                                <option value="{{ $product_subcategory->id }}" {{ (old('product_subcategory_id') == $product_subcategory_id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <span style="width: 115px; display: inline-block">商品写真</span>
                            <span>写真１</span>
                            <div style="text-align: center">
                                <div class="js-image1-error-target err-msg">
                                </div>
                                @if(!empty(old('image_1')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image" src="{{ "/uploads/".old('image_1') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1" value="{{ old('image_1') }}">
                                    </label>
                                @elseif(!empty($image_1))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image" src="{{ "/uploads/".$image_1 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1" value="{{ $image_1 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1">
                                    </label>
                                @endif


                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真２</span>
                            <div style="text-align: center">
                                <div class="js-image2-error-target err-msg">
                                </div>

                                @if(!empty(old('image_2')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image" src="{{ "/uploads/".old('image_2') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2" value="{{ old('image_2') }}">
                                    </label>
                                @elseif(!empty($image_2))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image" src="src="{{ "/uploads/".$image_2 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2" value="{{ $image_2 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2">
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真３</span>
                            <div style="text-align: center">
                                <div class="js-image3-error-target err-msg">
                                </div>

                                @if(!empty(old('image_3')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image" src="{{ "/uploads/".old('image_3') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3" value="{{ old('image_3') }}">
                                    </label>
                                @elseif(!empty($image_3))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image" src="{{ "/uploads/".$image_3 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3" value="{{ $image_3 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3">
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真４</span>
                            <div style="text-align: center">
                                <div class="js-image4-error-target err-msg">
                                </div>

                                @if(!empty(old('image_4')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image" src="{{ "/uploads/".old('image_4') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4" value="{{ old('image_4') }}">
                                    </label>
                                @elseif(!empty($image_4))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image" src="{{ "/uploads/".$image_4 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4" value="{{ $image_4 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4">
                                    </label>
                                @endif
                            </div>
                        </div>

                        <div class="form-group" style="display: flex; padding-top: 20px">
                            <div style="width: 115px; display: inline-block">商品説明</div>
                            <div style="width: 260px;">
                                <textarea style="width: 260px; height: 200px" type="text" name="product_content" required>{{old('product_content') ?? $product_content}}</textarea>
                            </div>
                        </div>


                        <div class="form-group btn-wrapper">
                            <input class="btn btn-back-blue" type="submit" value="確認画面へ">
                        </div>

                    </form>

                @else
                    <form method="post" action="{{ route('admin.producteditcheck') }}" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="hidden" name="member_id" value="{{ $product->member_id }}">
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
                            <lavel style="width: 115px; display: inline-block">商品ID</lavel>
                            <span>{{ $product->id }}</span>
                        </div>
                        <div class="form-group">
                            <lavel style="width: 115px; display: inline-block">商品名</lavel>
                            <input style="width: 260px;" type="text" name="name" required value="{{old('name') ?? $product->name}}">
                        </div>

                        <div class="form-group">
                            商品カテゴリ
                            <div class="form-inline">
                                <lavel for=""></lavel>
                                <select name="product_category_id" id="js-ajax-change-subcategories" required>
                                    <option value="0">選択してください</option>
                                    @if(!empty(old('product_category_id')))
                                        @if(!empty($product_categories))
                                            @foreach($product_categories as $product_category)
                                                <option value="{{ $product_category->id }}" {{ (old('product_category_id') == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                            @endforeach
                                        @endif
                                    @elseif(!empty($product->product_category_id))
                                        @if(!empty($product_categories))
                                            @foreach($product_categories as $product_category)
                                                <option value="{{ $product_category->id }}" {{ ($product->product_category_id == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                            @endforeach
                                        @endif
                                    @else
                                        @if(!empty($product_categories))
                                            @foreach($product_categories as $product_category)
                                                <option value="{{ $product_category->id }}" {{ (old('product_category_id') == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                            </div>
                            <div class="form-inline">
                                <lavel for=""></lavel>
                                {{--                        小カテゴリーをjQueryで生成--}}
                                <select required name="product_subcategory_id" id="js-ajax-target-field">
                                    @if(!empty(old('product_subcategory_id')))
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == old('product_category_id'))
                                                <option value="{{ $product_subcategory->id }}" {{ (old('product_subcategory_id') == $product->product_subcategory_id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach

                                    @elseif(!empty($product->product_subcategory_id))
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == $product->product_category_id)
                                                <option value="{{ $product_subcategory->id }}" {{ ($product->product_subcategory_id == $product->product_subcategory_id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == old('product_category_id'))
                                                <option value="{{ $product_subcategory->id }}" {{ (old('product_subcategory_id') == $product->product_subcategory_id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <span style="width: 115px; display: inline-block">商品写真</span>
                            <span>写真１</span>
                            <div style="text-align: center">
                                <div class="js-image1-error-target err-msg">
                                </div>
                                @if(!empty(old('image_1')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image" src="{{ "/uploads/".old('image_1') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1" value="{{ old('image_1') }}">
                                    </label>
                                @elseif(!empty($product->image_1))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image" src="{{ "/uploads/".$product->image_1 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1" value="{{ $product->image_1 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1">
                                    </label>
                                @endif


                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真２</span>
                            <div style="text-align: center">
                                <div class="js-image2-error-target err-msg">
                                </div>

                                @if(!empty(old('image_2')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image" src="{{ "/uploads/".old('image_2') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2" value="{{ old('image_2') }}">
                                    </label>
                                @elseif(!empty($product->image_2))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image" src="src="{{ "/uploads/".$product->image_2 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2" value="{{ $product->image_2 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2">
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真３</span>
                            <div style="text-align: center">
                                <div class="js-image3-error-target err-msg">
                                </div>

                                @if(!empty(old('image_3')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image" src="{{ "/uploads/".old('image_3') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3" value="{{ old('image_3') }}">
                                    </label>
                                @elseif(!empty($product->image_3))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image" src="{{ "/uploads/".$product->image_3 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3" value="{{ $product->image_3 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3">
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真４</span>
                            <div style="text-align: center">
                                <div class="js-image4-error-target err-msg">
                                </div>

                                @if(!empty(old('image_4')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image" src="{{ "/uploads/".old('image_4') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4" value="{{ old('image_4') }}">
                                    </label>
                                @elseif(!empty($product->image_4))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image" src="{{ "/uploads/".$product->image_4 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4" value="{{ $product->image_4 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4">
                                    </label>
                                @endif
                            </div>
                        </div>

                        <div class="form-group" style="display: flex; padding-top: 20px">
                            <div style="width: 115px; display: inline-block">商品説明</div>
                            <div style="width: 260px;">
                                <textarea style="width: 260px; height: 200px" type="text" name="product_content" required>{{old('product_content') ?? $product->product_content}}</textarea>
                            </div>
                        </div>


                        <div class="form-group btn-wrapper">
                            <input class="btn btn-back-blue" type="submit" value="確認画面へ">
                        </div>

                    </form>

                @endif


            @else
                <h2>商品登録</h2>

                @if(!empty($resend_flg))
                    <form method="post" action="{{ route('admin.productregistercheck') }}" enctype="multipart/form-data">
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
                            <lavel style="width: 115px; display: inline-block">商品ID</lavel>
                            <span>自動採番</span>
                        </div>
                        <div class="form-group">
                            <lavel style="width: 115px; display: inline-block">商品名</lavel>
                            <input style="width: 260px;" type="text" name="name" required value="{{old('name') ?? $name}}">
                        </div>

                        <div class="form-group">
                            商品カテゴリ
                            <div class="form-inline">
                                <lavel for=""></lavel>
                                <select name="product_category_id" id="js-ajax-change-subcategories" required>
                                    <option value="0">選択してください</option>
                                    @if(!empty($product_categories))
                                        @if(!empty(old('product_category_id')))
                                            @foreach($product_categories as $product_category)
                                                <option value="{{ $product_category->id }}" {{ (old('product_category_id') == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                            @endforeach
                                        @else
                                            @foreach($product_categories as $product_category)
                                                <option value="{{ $product_category->id }}" {{ ($product_category_id == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>
                            </div>
                            <div class="form-inline">
                                <lavel for=""></lavel>
                                {{--                        小カテゴリーをjQueryで生成--}}
                                <select required name="product_subcategory_id" id="js-ajax-target-field">
                                    @if(!empty(old('product_subcategory_id')))
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == old('product_category_id'))
                                                <option value="{{ $product_subcategory->id }}" {{ (old('product_subcategory_id') == $product_subcategory->id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach

                                     @elseif(!empty($product_subcategory_id))
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == $product_category_id))
                                                <option value="{{ $product_subcategory->id }}" {{ (old('product_subcategory_id') == $product_subcategory->id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == old('product_category_id'))
                                                <option value="{{ $product_subcategory->id }}" {{ (old('product_subcategory_id') == $product_subcategory->id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <span style="width: 115px; display: inline-block">商品写真</span>
                            <span>写真１</span>
                            <div style="text-align: center">
                                <div class="js-image1-error-target err-msg">
                                </div>
                                @if(!empty(old('image_1')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image" src="{{ "/uploads/".old('image_1') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1" value="{{ old('image_1') }}">
                                    </label>
                                @elseif(!empty($image_1))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image" src="{{ "/uploads/".$image_1 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1" value="{{ $image_1 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1">
                                    </label>
                                @endif


                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真２</span>
                            <div style="text-align: center">
                                <div class="js-image2-error-target err-msg">
                                </div>

                                @if(!empty(old('image_2')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image" src="{{ "/uploads/".old('image_2') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2" value="{{ old('image_2') }}">
                                    </label>
                                @elseif(!empty($image_2))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image" src="src="{{ "/uploads/".$image_2 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2" value="{{ $image_2 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2">
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真３</span>
                            <div style="text-align: center">
                                <div class="js-image3-error-target err-msg">
                                </div>

                                @if(!empty(old('image_3')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image" src="{{ "/uploads/".old('image_3') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3" value="{{ old('image_3') }}">
                                    </label>
                                @elseif(!empty($image_3))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image" src="{{ "/uploads/".$image_3 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3" value="{{ $image_3 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3">
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真４</span>
                            <div style="text-align: center">
                                <div class="js-image4-error-target err-msg">
                                </div>

                                @if(!empty(old('image_4')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image" src="{{ "/uploads/".old('image_4') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4" value="{{ old('image_4') }}">
                                    </label>
                                @elseif(!empty($image_4))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image" src="{{ "/uploads/".$image_4 }}">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4" value="{{ $image_4 }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4">
                                    </label>
                                @endif
                            </div>
                        </div>


                        <div class="form-group" style="display: flex; padding-top: 20px">
                            <div style="width: 115px; display: inline-block">商品説明</div>
                            <div style="width: 260px;">
                                <textarea style="width: 260px; height: 200px" type="text" name="product_content" required>{{old('product_content') ?? $product_content}}</textarea>
                            </div>
                        </div>


                        <div class="form-group btn-wrapper">
                            <input class="btn btn-back-blue" type="submit" value="確認画面へ">
                        </div>

                    </form>

                @else
                    <form method="post" action="{{ route('admin.productregistercheck') }}" enctype="multipart/form-data">
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
                            <lavel style="width: 115px; display: inline-block">商品ID</lavel>
                            <span>自動採番</span>
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
                                            <option value="{{ $product_category->id }}" {{ (old('product_category_id') == $product_category->id) ? 'selected': '' }}>{{ $product_category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-inline">
                                <lavel for=""></lavel>
                                {{--                        小カテゴリーをjQueryで生成--}}
                                <select required name="product_subcategory_id" id="js-ajax-target-field">
                                    @if(!empty(old('product_subcategory_id')))
                                        @foreach($product_subcategories as $product_subcategory)
                                            @if($product_subcategory->product_category_id == old('product_category_id'))
                                                <option value="{{ $product_subcategory->id }}" {{ (old('product_subcategory_id') == $product_subcategory->id) ? 'selected': '' }}>{{ $product_subcategory->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <span style="width: 115px; display: inline-block">商品写真</span>
                            <span>写真１</span>
                            <div style="text-align: center">
                                <div class="js-image1-error-target err-msg">
                                </div>
                                @if(!empty(old('image_1')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image" src="{{ "/uploads/".old('image_1') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1" value="{{ old('image_1') }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview1 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_1">アップロード
                                        <input class="js-image-uploader1" id="image_1" style="display: none;" type="file">
                                        <input class="js-image-path-hidden1" type="hidden" name="image_1">
                                    </label>
                                @endif


                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真２</span>
                            <div style="text-align: center">
                                <div class="js-image2-error-target err-msg">
                                </div>

                                @if(!empty(old('image_2')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image" src="{{ "/uploads/".old('image_2') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2" value="{{ old('image_2') }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview2 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_2">アップロード
                                        <input class="js-image-uploader2" id="image_2" style="display: none;" type="file">
                                        <input class="js-image-path-hidden2" type="hidden" name="image_2">
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真３</span>
                            <div style="text-align: center">
                                <div class="js-image3-error-target err-msg">
                                </div>

                                @if(!empty(old('image_3')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image" src="{{ "/uploads/".old('image_3') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3" value="{{ old('image_3') }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview3 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_3">アップロード
                                        <input class="js-image-uploader3" id="image_3" style="display: none;" type="file">
                                        <input class="js-image-path-hidden3" type="hidden" name="image_3">
                                    </label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="width: 115px; display: inline-block"></span>
                            <span>写真４</span>
                            <div style="text-align: center">
                                <div class="js-image4-error-target err-msg">
                                </div>

                                @if(!empty(old('image_4')))
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image" src="{{ "/uploads/".old('image_4') }}">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4" value="{{ old('image_4') }}">
                                    </label>
                                @else
                                    <div class="preview-image-wrapper">
                                        <img class="js-preview4 upload-image">
                                    </div>
                                    <label class="btn btn-back" for="image_4">アップロード
                                        <input class="js-image-uploader4" id="image_4" style="display: none;" type="file">
                                        <input class="js-image-path-hidden4" type="hidden" name="image_4">
                                    </label>
                                @endif
                            </div>
                        </div>

                        <div class="form-group" style="display: flex; padding-top: 20px">
                            <div style="width: 115px; display: inline-block">商品説明</div>
                            <div style="width: 260px;">
                                <textarea style="width: 260px; height: 200px" type="text" name="product_content" required>{{old('product_content')}}</textarea>
                            </div>
                        </div>


                        <div class="form-group btn-wrapper">
                            <input class="btn btn-back-blue" type="submit" value="確認画面へ">
                        </div>

                    </form>

                @endif

            @endif

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
                    url: '{{ route('admin.registImage') }}',
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
                        $('.js-image1-error-target').append('<p>ファイルのサイズが大きすぎます。10MB以下にしてください</p>')
                    }
                    if(error.statusText == 'Unprocessable Entity') {
                        console.log(error.statusText);
                        $('.js-image1-error-target').append('<p>１０MBまでのjpg、jpeg、png、gifのファイルのみアップロード可能です</p>')
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
                    url: '{{ route('admin.registImage') }}',
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
                        console.log(error.statusText)
                        // $('').append('<p>'+error.statusText+'</p>');
                        $('.js-image1-error-target').append('<p>ファイルのサイズが大きすぎます。10MB以下にしてください</p>')
                    }
                    if(error.statusText == 'Unprocessable Entity') {
                        console.log(error.statusText);
                        $('.js-image1-error-target').append('<p>１０MBまでのjpg、jpeg、png、gifのファイルのみアップロード可能です</p>')
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
                    url: '{{ route('admin.registImage') }}',
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
                        console.log(error.statusText)
                        // $('').append('<p>'+error.statusText+'</p>');
                        $('.js-image1-error-target').append('<p>ファイルのサイズが大きすぎます。10MB以下にしてください</p>')
                    }
                    if(error.statusText == 'Unprocessable Entity') {
                        console.log(error.statusText);
                        $('.js-image1-error-target').append('<p>１０MBまでのjpg、jpeg、png、gifのファイルのみアップロード可能です</p>')
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
                    url: '{{ route('admin.registImage') }}',
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
                        console.log(error.statusText)
                        // $('').append('<p>'+error.statusText+'</p>');
                        $('.js-image1-error-target').append('<p>ファイルのサイズが大きすぎます。10MB以下にしてください</p>')
                    }
                    if(error.statusText == 'Unprocessable Entity') {
                        console.log(error.statusText);
                        $('.js-image1-error-target').append('<p>１０MBまでのjpg、jpeg、png、gifのファイルのみアップロード可能です</p>')
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
