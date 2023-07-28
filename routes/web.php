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

// 管理者画面・ログイン・ログアウト

Route::get('admin/login', 'AdminController@showAdminLoginForm')->name('admin.login');
Route::post('admin/login', 'AdminController@adminLogin');
Route::post('admin/logout', 'AdminController@logout')->name('admin.logout');

Route::get('admin', 'AdminController@index')->name('admin')->middleware('admin');

// 会員一覧
Route::get('admin/list', 'AdminController@showList')->name('admin.list');

Route::get('admin/list/edit', 'AdminController@memberEdit')->name('admin.list.edit');
Route::post('admin/list/confirm', 'AdminController@toMemberConfirm')->name('admin.list.confirm');
Route::post('admin/list/complete', 'AdminController@memberComplete')->name('admin.list.complete');

Route::get('admin/list/detail', 'AdminController@memberDetail')->name('admin.list.detail');
Route::post('admin/list/detail/detele', 'AdminController@memberDetailDelete')->name('admin.list.detail.delete');


// 商品カテゴリ一覧
Route::get('admin/category_list', 'AdminController@showCategoryList')->name('admin.category_list');

Route::get('admin/category_list/edit', 'AdminController@categoryEdit')->name('admin.category_list.edit');
Route::post('admin/category_list/confirm', 'AdminController@toCategoryConfirm')->name('admin.category_list.confirm');
Route::post('admin/category_list/complete', 'AdminController@categoryComplete')->name('admin.category_list.complete');

Route::get('admin/category_list/detail', 'AdminController@categoryDetail')->name('admin.category_list.detail');
Route::post('admin/category_list/detail/detele', 'AdminController@categoryDetailDelete')->name('admin.category_list.detail.delete');


// 商品一覧
Route::get('admin/product/list', 'AdminProductController@showProductList')->name('admin.product.list');

Route::get('admin/product/edit', 'AdminProductController@productEdit')->name('admin.product.edit');
Route::post('admin/product/confirm', 'AdminProductController@toProductConfirm')->name('admin.product.confirm');
Route::post('admin/product/complete', 'AdminProductController@productComplete')->name('admin.product.complete');

Route::get('admin/product/detail', 'AdminProductController@toProductDetail')->name('admin.product.detail');
Route::post('admin/product/detail/detele', 'AdminProductController@productDetailDelete')->name('admin.product.detail.delete');

Route::post('admin/product/select', 'AdminProductController@fetch');
Route::post('admin/product/upload', 'AdminProductController@upload');


// 商品レビュー一覧
Route::get('admin/review/list', 'AdminReviewController@showReviewList')->name('admin.review.list');

Route::get('admin/review/edit', 'AdminReviewController@reviewEdit')->name('admin.review.edit');
Route::post('admin/review/confirm', 'AdminReviewController@toReviewConfirm')->name('admin.review.confirm');
Route::post('admin/review/complete', 'AdminReviewController@reviewComplete')->name('admin.review.complete');

Route::get('admin/review/detail', 'AdminReviewController@toReviewDetail')->name('admin.review.detail');
Route::post('admin/review/detail/detele', 'AdminReviewController@reviewDetailDelete')->name('admin.review.detail.delete');

Route::post('admin/review/select', 'AdminReviewController@fetch');
Route::post('admin/review/upload', 'AdminReviewController@upload');
