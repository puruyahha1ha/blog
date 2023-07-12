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
    return view('regist.member_regist');
});
Route::get('/top', function () {
    return view('top');
})->name('top');

Route::post('/regist/confirm', 'RegistController@check')->name('confirm');
Route::post('/regist/complete', 'RegistController@regist')->name('complete');