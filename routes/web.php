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

Route::post('list', 'ListController@search')->name('list.search');

Route::get('list/detail', 'ListController@toDetail')->name('list.detail');

Route::get('list/back', 'ListController@listBack')->name('list.back');

Route::get('list/register', 'ListController@toRegister')->name('list.register');

Route::get('list/review', 'ListController@toReview')->name('list.review');

Route::post('list/confirm', 'ListController@toConfirmForm')->name('review.confirm');

Route::post('list/complete', 'ListController@complete')->name('review.complete');