@extends('layouts.templete')
@section('title', 'マイページ')
@section('header_class', 'login_header')
@section('header')
    <p>マイページ</p>
    <div class="header_button">
        <a href="/">トップに戻る</a>
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            ログアウト
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
@endsection
@section('main')
    {{-- 氏名 --}}
    <div class="form_row">
        <p>氏名</p>
        <p>{{ Auth::user()->name_sei }}　{{ Auth::user()->name_mei }}</p>
    </div>

    {{-- ニックネーム --}}
    <div class="form_row">
        <p>ニックネーム</p>
        <p>{{ Auth::user()->nickname }}</p>
    </div>

    {{-- 性別 --}}
    <div class="form_row">
        <p>性別</p>
        @if (Auth::user()->gender == 1)
            <p>男性</p>
        @else
            <p>女性</p>
        @endif
    </div>

    {{-- 会員情報変更 --}}
    <div class="mypage_button">
        <a href="{{ route('mypage.info') }}">会員情報変更</a>
    </div>

    {{-- パスワード --}}
    <div class="form_row">
        <p>パスワード</p>
        <p>セキュリティのため非表示</p>
    </div>

    {{-- パスワード変更 --}}
    <div class="mypage_button">
        <a href="{{ route('mypage.password') }}">パスワード変更</a>
    </div>


    {{-- メールアドレス --}}
    <div class="form_row">
        <p>メールアドレス</p>
        <p style="color: blue">{{ Auth::user()->email }}</p>
    </div>

    {{-- メールアドレス変更 --}}
    <div class="mypage_button">
        <a href="{{ route('mypage.email') }}" style="margin-bottom: 20px">メールアドレス変更</a>
    </div>

    {{-- 商品レビュー管理 --}}
    <div class="mypage_button">
        <a href="{{ route('mypage.control') }}" style="margin-bottom: 20px">商品レビュー管理</a>
    </div>

    {{-- 退会ボタン --}}
    <div class="detail_button_re">
        <a href="{{ route('withdrawal') }}">退会</a>
    </div>

@endsection
