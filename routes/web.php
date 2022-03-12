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
    Route::get('/mypage', 'MemberController@mypage')->name('mypage')->middleware('authMember');
    Route::get('/withdraw/show','MemberController@withdrawshow' )->name('withdrawshow')->middleware('authMember');
//    Route::get('/withdraw/confirm','MemberController@withdrawconfirm' )->name('withdrawconfirm')->middleware('authMember');
    Route::post('/withdraw/complete','MemberController@withdrawcomplete' )->name('withdrawcomplete')->middleware('authMember');


    // 編集関連
    // 登録情報
    Route::get('/mypage/edit/memberinfo', 'MemberController@editmemberinfoshow')->name('editmemberinfoshow')->middleware('authMember');
    Route::post('/mypage/edit/memberinfoconfirm', 'MemberController@editmemberinfoconfirm')->name('editmemberinfoconfirm')->middleware('authMember');
    Route::post('/mypage/edit/editmemberinfocomplete', 'MemberController@editmemberinfocomplete')->name('editmemberinfocomplete')->middleware('authMember');
    // パスワード変更
    Route::get('/mypage/edit/password', 'MemberController@editpasswordshow')->name('editpasswordshow')->middleware('authMember');
    Route::post('/mypage/edit/editpasswordcomplete', 'MemberController@editpasswordcomplete')->name('editpasswordcomplete')->middleware('authMember');
    // パスワード変更

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
    Route::post('/regist/productstorecheck', 'ProductController@productStorecheck')->name('productStorecheck')->middleware('authMember');
    // ajaxで画像をアップロード
    Route::post('/regist/productimage', 'ProductController@registImage')->name('registImage')->middleware('authMember');

    Route::post('/regist/productstore', 'ProductController@productStore')->name('productStore')->middleware('authMember');

    Route::get('/show', 'ProductController@show')->name('show');

    Route::get('/show/detail', 'ProductController@detail')->name('detail');

    Route::get('/show/search', 'ProductController@search')->name('search');

    Route::get('/review', 'ProductController@reviewregist')->name('reviewregist')->middleware('authMember');
    Route::post('/review/confirm', 'ProductController@reviewconfirm')->name('reviewconfirm')->middleware('authMember');

    Route::post('/review/store', 'ProductController@reviewstore')->name('reviewstore')->middleware('authMember');

    Route::get('/review/show', 'ProductController@reviewshow')->name('reviewshow');

});

//Route::get('/mail', 'MailSendController@send');
