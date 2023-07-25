@extends('layouts.templete')
@section('title', 'ログインフォーム')
@section('head')
    <style>
        header {
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
@section('main')
    <h1>管理画面</h1>

    <form action="{{ route('admin.login') }}" method="post">
        @csrf

        {{-- ログインID --}}
        <div class="form_row">
            <p>ログインID</p>
            <input type="text" name="login_id" value="{{ old('login_id') }}">
        </div>

        {{-- ログインIDのエラーメッセージ --}}
        @error('login_id')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- パスワード --}}
        <div class="form_row">
            <p>パスワード</p>
            <input type="password" name="password">
        </div>

        {{-- パスワードのエラーメッセージ --}}
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- ログインボタン --}}
        <div class="button">
            <input type="submit" value="ログイン" class="admin_login">
        </div>

    </form>
@endsection
