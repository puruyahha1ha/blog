@extends('layouts.templete')
@section('title', 'トップ画面')
@auth
    @section('header_class', 'login_header')
@endauth
@section('header')
    @if (Route::has('login'))
        @auth
            <p>ようこそ{{ Auth::user()->name_sei }}　{{ Auth::user()->name_mei }}様</p>
            <div class="buttons">
                <a href="{{ route('list') }}">商品一覧</a>
                <a href="{{ route('product') }}">新規商品登録</a>
                <a href="{{ route('mypage') }}">マイページ</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @else
            @if (Route::has('register'))
                <a href="{{ route('list') }}">商品一覧</a>
                <a href="{{ route('register') }}">新規会員登録</a>
            @endif
            <a href="{{ route('login') }}">ログイン</a>
        @endauth
    @endif
@endsection
