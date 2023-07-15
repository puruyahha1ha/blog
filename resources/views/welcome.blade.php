@extends('layouts.templete')
@section('title', 'トップ画面')
@auth
    @section('header_class', 'login_header')
@endauth
@section('header')
    @if (Route::has('login'))
        @auth
            <p>ようこそ{{ Auth::user()->name_sei }}　{{ Auth::user()->name_mei }}様</p>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログアウト
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            @if (Route::has('register'))
                <a href="{{ route('register') }}">新規会員登録</a>
            @endif
            <a href="{{ route('login') }}">ログイン</a>
        @endauth
    @endif
@endsection
