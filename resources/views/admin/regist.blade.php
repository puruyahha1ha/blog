@extends('layouts.templete')
@section('title', '会員登録')
@section('head')
    <style>
        .login_header {
            background-color: #d9d9d9;
        }

        body {
            background-color: #ddebf7;
            height: 100%;
        }

        footer {
            background-color: #d9d9d9;
            width: 100%;
            height: 60px;
        }
    </style>
@endsection
@section('header_class', 'login_header')
@section('header')
    <p>会員登録</p>
    <a href="/admin/list">一覧へ戻る</a>
@endsection
@section('main')
    <form action="{{ route('admin.list.confirm') }}" method="post">
        @csrf

        {{-- ID --}}
        <div class="form_row">
            <p>ID</p>
            <p>登録後に自動採番</p>
        </div>

        {{-- 氏名 --}}
        <div class="name">
            <p>氏名</p>
            <span>姓</span>
            <input type="text" name="name_sei" value="{{ old('name_sei') }}">
            <span>名</span>
            <input type="text" name="name_mei" value="{{ old('name_mei') }}">
        </div>

        {{-- 姓のエラーメッセージ --}}
        @error('name_sei')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 名のエラーメッセージ --}}
        @error('name_mei')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- ニックネーム --}}
        <div class="form_row">
            <p>ニックネーム</p>
            <input type="text" name="nickname" value="{{ old('nickname') }}">
        </div>

        {{-- ニックネームのエラーメッセージ --}}
        @error('nickname')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 性別 --}}
        <div class="gender">
            <p>性別</p>
            @foreach (Config('master.gender') as $key => $value)
                <input type="radio" name="gender" value="{{ $key }}" id="{{ $value }}" @if (old('gender') == $key) checked @endif>
                <label for="{{ $value }}">{{ $value }}</label>
            @endforeach
        </div>

        {{-- 性別のエラーメッセージ --}}
        @error('gender')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- パスワード --}}
        <div class="form_row">
            <p>パスワード</p>
            <input type="password" name="password" value="{{ old('password') }}">
        </div>

        {{-- パスワードのエラーメッセージ --}}
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- パスワード確認 --}}
        <div class="form_row">
            <p>パスワード確認</p>
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
        </div>

        {{-- パスワード確認のエラーメッセージ --}}
        @error('password_confirmation')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- メールアドレス --}}
        <div class="form_row">
            <p>メールアドレス</p>
            <input type="text" name="email" value="{{ old('email') }}">
        </div>

        {{-- メールアドレスのエラーメッセージ --}}
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <input type="hidden" name="from" value="regist">
        <div class="search_button">
            <input type="submit" name="confirm" value="確認画面へ">
        </div>

    </form>
@endsection
