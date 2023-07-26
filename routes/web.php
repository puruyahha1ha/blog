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

Route::get('list/register', 'ListController@toRegister')->name('list.register')->middleware('auth');

Route::get('list/review', 'ListController@toReview')->name('list.review');
Route::post('list/confirm', 'ListController@toConfirmForm')->name('review.confirm');
Route::post('list/complete', 'ListController@complete')->name('review.complete');



Route::get('mypage', 'MyPageController@toMyPage')->name('mypage');

Route::get('mypage/withdrawal', 'MyPageController@toWithdrawal')->name('withdrawal');
Route::get('mypage/withdrawal/complete', 'MyPageController@completeWithdrawal')->name('withdrawal.complete');


Route::get('mypage/info', 'MyPageController@toInfoUpdate')->name('mypage.info');
Route::post('mypage/info/confirm', 'MyPageController@toInfoUpdateConfirm')->name('mypage.info.confirm');
Route::post('mypage/info/complete', 'MyPageController@infoUpdateComplete')->name('mypage.info.complete');

Route::get('mypage/password', 'MyPageController@toPasswordUpdate')->name('mypage.password');
Route::post('mypage/password/complete', 'MyPageController@passwordUpdateComplete')->name('mypage.password.complete');


Route::get('mypage/email', 'MyPageController@toEmailUpdate')->name('mypage.email');
Route::post('mypage/email/confirm', 'MyPageController@emailUpdateConfirm')->name('mypage.email.confirm');
Route::get('mypage/email/showemail', 'MyPageController@showEmail')->name('mypages.showEmail');
Route::post('mypage/email/complete', 'MyPageController@emailUpdateComplete')->name('mypage.email.complete');

Route::get('mypage/control', 'MyPageController@toReviewControl')->name('mypage.control');

Route::get('mypage/control/update', 'MyPageController@toReviewUpdate')->name('mypage.control.update');
Route::post('mypage/control/confirm', 'MyPageController@toReviewConfirm')->name('mypage.control.confirm');
Route::post('mypage/control/complete', 'MyPageController@reviewComplete')->name('mypage.control.complete');

Route::get('mypage/control/delete', 'MyPageController@toReviewDelete')->name('mypage.control.delete');
Route::post('mypage/control/delete/complete', 'MyPageController@reviewDeleteComplete')->name('mypage.control.delete.complete');


Route::get('admin/login', 'AdminController@showAdminLoginForm')->name('admin.login');
Route::post('admin/login', 'AdminController@adminLogin');

Route::post('admin/logout', 'AdminController@logout')->name('admin.logout');

Route::get('admin', 'AdminController@index')->name('admin')->middleware('admin');

Route::get('admin/list', 'AdminController@showList')->name('admin.list');

Route::get('admin/list/edit', 'AdminController@memberEdit')->name('admin.list.edit');
Route::get('admin/list/detail', 'AdminController@memberDetail')->name('admin.list.detail');
Route::post('admin/list/detail/detele', 'AdminController@memberDetailDelete')->name('admin.list.detail.delete');

Route::post('admin/list/confirm', 'AdminController@toMemberConfirm')->name('admin.list.confirm');

Route::post('admin/list/complete', 'AdminController@memberComplete')->name('admin.list.complete');

Route::get('admin/category_list', 'AdminController@showCategoryList')->name('admin.category_list');
Route::get('admin/category_list/edit', 'AdminController@memberEdit')->name('admin.category_list.edit');
Route::get('admin/category_list/detail', 'AdminController@memberDetail')->name('admin.category_list.detail');

