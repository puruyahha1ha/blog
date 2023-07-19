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

Auth::routes();

Route::get('regist/complete', 'Auth\RegisterController@showRegistCompleteForm');

Route::post('register/confirm', 'Auth\RegisterController@toConfirmForm')->name('register.confirm');

Route::get('password/email/complete', 'Auth\ForgotPasswordController@toEmailComplete')->name('email.complete');

Route::get('product', 'ProductController@showRegistProductForm')->name('product');
Route::post('product', 'ProductController@showRegistProductForm');

Route::post('product/category', 'ProductController@fetch');

Route::post('product/upload', 'ProductController@upload');

Route::post('product/confirm', 'ProductController@toConfirmForm')->name('product.confirm');

Route::post('product/complete', 'ProductController@complete')->name('product.complete');

Route::get('list', 'ListController@toList')->name('list');