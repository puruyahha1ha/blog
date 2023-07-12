@extends('layouts.templete')
@section('title', 'トップ画面')
@section('header')
    @auth
        <p>ログイン</p>
    @else
        <p>ログアウト</p>
    @endauth
@endsection
