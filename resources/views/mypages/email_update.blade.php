@extends('layouts.templete')
@section('title', 'メールアドレス変更画面')
@section('header')
    <style>
        header {
            display: none;
        }
    </style>
@endsection
@section('main')
    <h1>メールアドレス変更</h1>

    <form action="{{ route('mypage.email.confirm') }}" method="post">
        @csrf

        {{-- 現在のメールアドレス --}}
        <div class="form_row">
            <p>現在のメールアドレス</p>
            <p style="color: blue">{{ Auth::user()->email }}</p>
        </div>

        {{-- 変更後のメールアドレス --}}
        <div class="form_row">
            <p>変更後のメールアドレス</p>
            <input type="text" name="email">
        </div>

        {{-- 変更後のメールアドレスのエラーメッセージ --}}
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 認証メール送信 --}}
        <div class="button">
            <input type="submit" value="認証メール送信" class="submit">
        </div>

    </form>

    {{-- マイページに戻る --}}
    <div class="button">
        <a href="{{ route('mypage') }}" class="submit_re" style="margin-top: 0px">マイページに戻る</a>
    </div>

@endsection
