@extends('layouts.templete')
@section('title', 'メールアドレス変更認証完了ページ')
@section('header')
    <style>
        header {
            display: none;
        }
    </style>
@endsection
@section('main')
    <h1>メールアドレス変更 認証コード入力</h1>
    <p>（※メールアドレスの変更はまだ完了していません）</p>
    <p>変更後のメールアドレスにお送りしましたメールに記載されている「認証コード」を入力してください。</p>


    <form action="{{ route('mypage.email.complete') }}" method="post">
        @csrf
        <input type="hidden" name="email" id="" value="{{ $email }}">

        {{-- 認証コード --}}
        <div class="form_row" style="margin-top: 50px">
            <p>認証コード</p>
            <input type="text" name="auth_code">
        </div>

        {{-- 認証コードのエラーメッセージ --}}
        @error('auth_code')
            <div class="error" style="margin-bottom: 50px">{{ $message }}</div>
        @enderror

        {{-- 認証メール送信 --}}
        <div class="button">
            <input type="submit" value="認証コードを送信してメールアドレスの変更を完了する" class="submit" style="width: auto">
        </div>

    </form>
@endsection
