@extends('layouts.templete')
@section('title', 'パスワード変更画面')
@section('header')
    <style>
        header {
            display: none;
        }
    </style>
@endsection
@section('main')
    <h1>パスワード変更</h1>

    <form action="{{ route('mypage.password.complete') }}" method="post">
        @csrf

        {{-- パスワード --}}
        <div class="form_row">
            <p>パスワード</p>
            <input type="password" name="password">
        </div>

        {{-- パスワードのエラーメッセージ --}}
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror


        {{-- パスワード確認 --}}
        <div class="form_row">
            <p>パスワード確認</p>
            <input type="password" name="password_confirmation">
        </div>

        {{-- パスワード確認のエラーメッセージ --}}
        @error('password_confirmation')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- パスワードを変更 --}}
        <div class="button">
            <input type="submit" value="パスワードを変更" class="submit">
        </div>

    </form>

    {{-- マイページに戻る --}}
    <div class="button">
        <a href="{{ route('mypage') }}" class="submit_re" style="margin-top: 0px">マイページに戻る</a>
    </div>

@endsection
