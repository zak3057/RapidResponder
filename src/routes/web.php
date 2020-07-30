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


// お問い合わせ
Route::get('contact', 'ContactsController@index')->name('contact.index');
// お問い合わせ確認
Route::post('contact/confirm', 'ContactsController@confirm')->name('contact.confirm');
// 送信完了
Route::post('contact/thanks', 'ContactsController@send')->name('contact.send');




// ログイン
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
