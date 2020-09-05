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

Route::get('/', function () {
    return view('welcome');
});


// ===================================================================================
// お問い合わせ
Route::get('contact', 'ContactsController@index')->name('contact.index');
// お問い合わせ確認
Route::post('contact/confirm', 'ContactsController@confirm')->name('contact.confirm');
// 送信完了
Route::post('contact/thanks', 'ContactsController@send')->name('contact.send');



// ===================================================================================
// ログイン
Auth::routes();
// ユーザー登録不可
// Route::match(['get', 'post'], 'register', function () { return abort(403, 'Forbidden'); })->name('register');
Route::get('home', 'HomeController@index')->name('home');



// ===================================================================================
// お問い合わせ一覧
Route::get('contact/archive', 'ContactArchiveController@index')->name('contact.archive.index');
// ===================================================================================
// お問い合わせ詳細

// index
Route::get('contact/archive/detail', 'ContactDetailController@index')->name('contact.archive.detail.index');
// 対応開始
Route::get('contact/archive/detail/start', 'ContactDetailController@start')->name('contact.archive.detail.start');
// 未対応に戻す
Route::get('contact/archive/detail/return', 'ContactDetailController@returnStatus')->name('contact.archive.detail.return');
// 対応済み
Route::get('contact/archive/detail/complete', 'ContactDetailController@complete')->name('contact.archive.detail.complete');
// メッセージ送信
Route::post('contact/archive/detail/message', 'ContactDetailController@message')->name('contact.archive.detail.message');
// コメント登録
Route::post('contact/archive/detail/comment', 'ContactDetailController@comment')->name('contact.archive.detail.comment');