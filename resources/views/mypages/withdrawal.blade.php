@extends('layouts.templete')
@section('title', '退会ページ')
@section('header')
    <a href="/">トップに戻る</a>
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ログアウト
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endsection
@section('main')
    <p style="margin: 100px 0 50px 0">退会します。よろしいですか？</p>

    {{-- マイページに戻る --}}
    <div class="detail_button_re">
        <a href="{{ route('mypage') }}">マイページに戻る</a>
    </div>

    {{-- 退会する --}}
    <div class="detail_button">
        <a href="{{ route('withdrawal.complete') }}" class="button" style="width: 200px">退会する</a>
    </div>

@endsection
