<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('member_regist', 'MemberController@regist')->name('member_regist');
//Route::post('member_regist_confirm', 'MemberController@confirm')->name('member_regist_confirm');
//Auth::routes();

Route::prefix('members')->name('members.')->group(function () {
    Route::get('/regist', 'MemberController@regist')->name('regist')->middleware('authMember');
    Route::post('/regist_confirm', 'MemberController@confirm')->name('regist_confirm');
    Route::post('/regist_complete', 'MemberController@complete')->name('regist_complete');
    Route::get('/login', 'MemberController@loginshow')->name('login')->middleware('authMember');
    Route::post('/login', 'MemberController@login')->name('login')->middleware('authMember');
    // ログイン処理を書く
    Route::post('/logout', 'MemberController@logout')->name('logout')->middleware('authMember');
});
Route::get('/', 'MemberController@index')->name('index');

// パスワード再設定のためにメールアドレスを入力してもらう画面表示
Route::get('/password/confirm', 'MemberController@showPasswordConfirmForm')->name('password.confirm');

// ここでは、パスワード再設定メールを送信
Route::post('/password/confirm', 'MemberController@passwordConfirmSend')->name('password.confirm');
Route::get('/password/confirm/{token}','MemberController@passwordConfirmCheckToken')->name('password.checktoken');
Route::post('/password/update','MemberController@passwordUpdate')->name('password.update');


Route::prefix('products')->name('products.')->group(function () {
    Route::get('/regist', 'ProductController@registForm')->name('registForm')->middleware('authMember');
    Route::post('/regist', 'ProductController@regist')->name('regist')->middleware('authMember');

    // ajax通信でサブカテゴリー情報をとる
    Route::get('/regist/getsubcategory/{categoryid}', 'ProductController@getSubCategories')->name('getSubCategories');
    //
    Route::post('/regist/productstore', 'ProductController@productStore')->name('productStore')->middleware('authMember');
    // ajaxで画像をアップロード
    Route::post('/regist/productimage', 'ProductController@registImage')->name('registImage')->middleware('authMember');

    Route::get('/show', 'ProductController@show')->name('show');

    Route::get('/show/search', 'ProductController@search')->name('search');

});

//Route::get('/mail', 'MailSendController@send');
