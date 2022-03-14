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
    Route::post('/mypage/edit/memberinfocomplete', 'MemberController@editmemberinfocomplete')->name('editmemberinfocomplete')->middleware('authMember');
    // パスワード変更
    Route::get('/mypage/edit/password', 'MemberController@editpasswordshow')->name('editpasswordshow')->middleware('authMember');
    Route::post('/mypage/edit/passwordcomplete', 'MemberController@editpasswordcomplete')->name('editpasswordcomplete')->middleware('authMember');
    // メールアドレス変更
    Route::get('/mypage/edit/email', 'MemberController@editemailshow')->name('editemailshow')->middleware('authMember');
    // メールを送る処理
    Route::post('/mypage/edit/emailconfirm', 'MemberController@editemailconfirm')->name('editemailconfirm')->middleware('authMember');
    // メール認証入力画面を表示するだけの処理
    Route::get('/mypage/edit/emailconfirmshow', 'MemberController@editemailconfirmshow')->name('editemailconfirmshow')->middleware('authMember');
    // メールを更新する処理
    Route::post('/mypage/edit/emailcomplete', 'MemberController@editemailcomplete')->name('editemailcomplete')->middleware('authMember');

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

    Route::post('/regist/re', 'ProductController@registFormre')->name('registFormre')->middleware('authMember');



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

    // プロダクトのレビューを編集
    Route::get('/review/edit/management', 'ReviewController@revieweditmanagement')->name('revieweditmanagement')->middleware('authMember');
    Route::get('/review/edit/show', 'ReviewController@revieweditshow')->name('revieweditshow')->middleware('authMember');
    Route::post('/review/edit/confirm', 'ReviewController@revieweditconfirm')->name('revieweditconfirm')->middleware('authMember');
    Route::post('/review/edit/complete', 'ReviewController@revieweditcomplete')->name('revieweditcomplete')->middleware('authMember');

    Route::get('/review/edit/deleteshow', 'ReviewController@revieweditdeleteshow')->name('revieweditdeleteshow')->middleware('authMember');
    Route::post('/review/edit/delete', 'ReviewController@revieweditdelete')->name('revieweditdelete')->middleware('authMember');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', 'AdministerController@index')->name('index');
    Route::get('/login', 'AdministerController@loginshow')->name('loginshow')->middleware('authAdmin');
    Route::post('/login', 'AdministerController@login')->name('login')->middleware('authAdmin');
    Route::post('logout', 'AdministerController@logout')->name('logout')->middleware('authAdmin');

    // 管理者　会員一覧表示と検索
    Route::get('/members/show', 'AdministerController@membershow')->name('membershow')->middleware('authAdmin');

    // 管理　会員一覧からの会員追加登録
    Route::get('/members/register', 'AdministerController@memberregister')->name('memberregister')->middleware('authAdmin');
    Route::post('/members/registerconfirm', 'AdministerController@memberregisterconfirm')->name('memberregisterconfirm')->middleware('authAdmin');
    Route::post('/members/registercomplete', 'AdministerController@memberregistercomplete')->name('memberregistercomplete')->middleware('authAdmin');


    // // 管理　会員一覧からの編集
    Route::get('/members/edit', 'AdministerController@membereditshow')->name('membereditshow')->middleware('authAdmin');
    Route::post('/members/editconfirm', 'AdministerController@membereditconfirm')->name('membereditconfirm')->middleware('authAdmin');
    Route::post('/members/editcomplete', 'AdministerController@membereditcomplete')->name('membereditcomplete')->middleware('authAdmin');

    // 管理者　会員詳細
    Route::get('/members/detail', 'AdministerController@memberdetailshow')->name('memberdetailshow')->middleware('authAdmin');
    Route::post('/members/delete', 'AdministerController@memberdelete')->name('memberdelete')->middleware('authAdmin');

    // 管理者　商品カテゴリー一覧、検索
    Route::get('/products/category/show', 'AdministerController@productscategoryshow')->name('productscategoryshow')->middleware('authAdmin');

    // 管理者商品カテゴリ一覧からの編集
    Route::get('/products/category/edit', 'AdministerController@productscategoryedit')->name('productscategoryedit')->middleware('authAdmin');
    Route::post('/products/category/editconfirm', 'AdministerController@productscategoryeditconfirm')->name('productscategoryeditconfirm')->middleware('authAdmin');
    Route::post('/products/category/editcomplete', 'AdministerController@productscategoryeditcomplete')->name('productscategoryeditcomplete')->middleware('authAdmin');

    // 管理者　商品カテゴリー一覧から商品カテゴリ詳細
    Route::get('/products/category/detail', 'AdministerController@productscategorydetail')->name('productscategorydetail')->middleware('authAdmin');

    // 管理者　商品カテゴリーの削除
    Route::post('/products/category/delete', 'AdministerController@productscategorydelete')->name('productscategorydelete')->middleware('authAdmin');


    // 管理者商品カテゴリ一覧からの登録
    Route::get('/products/category/register', 'AdministerController@productscategoryregister')->name('productscategoryregister')->middleware('authAdmin');
    Route::post('/products/category/registerconfirm', 'AdministerController@productscategoryregisterconfirm')->name('productscategoryregisterconfirm')->middleware('authAdmin');
    Route::post('/products/category/registercomplete', 'AdministerController@productscategoryregistercomplete')->name('productscategoryregistercomplete')->middleware('authAdmin');

    // 管理者商品一覧
    Route::get('/products/show', 'AdministerController@productsshow')->name('productsshow')->middleware('authAdmin');





});

//Route::get('/mail', 'MailSendController@send');
