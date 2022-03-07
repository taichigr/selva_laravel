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
    Route::get('/regist', 'MemberController@regist')->name('regist');
    Route::post('/regist_confirm', 'MemberController@confirm')->name('regist_confirm');
    Route::post('/regist_complete', 'MemberController@complete')->name('regist_complete');
});
