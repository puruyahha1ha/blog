@extends('layouts.templete')

@section('title', '登録画面')

@section('main')
    <h1>会員情報登録</h1>

    <form action="{{ route('confirm') }}" method="POST">
        @csrf
        <div id="regist_form">
            {{-- 氏名 --}}
            <div class="name">
                <p>氏名</p>
                <span>姓</span>
                <input type="text" name="name_sei" value="{{ old('name_sei') }}">
                <span>名</span>
                <input type="text" name="name_mei" value="{{ old('name_mei') }}">
            </div>
            {{-- 姓のエラーメッセージ --}}
            @if ($errors->has('name_sei'))
                <div class="error">{{ $errors->first('name_sei') }}</div>
            @endif
            {{-- 名のエラーメッセージ --}}
            @if ($errors->has('name_mei'))
                <div class="error">{{ $errors->first('name_mei') }}</div>
            @endif
            {{-- ニックネーム --}}
            <div class="form_row">
                <p>ニックネーム</p>
                <input type="text" name="nickname" value="{{ old('nickname') }}">
            </div>
            {{-- ニックネームのエラーメッセージ --}}
            @if ($errors->has('nickname'))
                <div class="error">{{ $errors->first('nickname') }}</div>
            @endif
            {{-- 性別 --}}
            <div class="gender">
                <p>性別</p>
                @foreach (Config('master.gender') as $key => $value)
                    <input type="radio" name="gender" value="{{ $key }}" id="{{ $value }}"
                        {{ old('gender') == $key ? 'checked' : '' }}><label
                        for="{{ $value }}">{{ $value }}</label>
                @endforeach
            </div>
            {{-- 性別のエラーメッセージ --}}
            @if ($errors->has('gender'))
                <div class="error">{{ $errors->first('gender') }}</div>
            @endif
            {{-- パスワード --}}
            <div class="form_row">
                <p>パスワード</p>
                <input type="password" name="password_a" value="{{ old('password_a') }}">
            </div>
            {{-- パスワードのエラーメッセージ --}}
            @if ($errors->has('password_a'))
                <div class="error">{{ $errors->first('password_a') }}</div>
            @endif
            {{-- パスワード確認 --}}
            <div class="form_row">
                <p>パスワード確認</p>
                <input type="password" name="password_check" value="{{ old('password_check') }}">
            </div>
            {{-- パスワード確認のエラーメッセージ --}}
            @if ($errors->has('password_check'))
                <div class="error">{{ $errors->first('password_check') }}</div>
            @endif
            {{-- メールアドレス --}}
            <div class="form_row">
                <p>メールアドレス</p>
                <input type="text" name="email" value="{{ old('email') }}">
            </div>
            {{-- メールアドレスのエラーメッセージ --}}
            @if ($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="button">
            <input type="submit" name="confirm" value="確認画面へ" class="submit">
            <input type="submit" name="confirm" value="トップに戻る" class="submit_re">
        </div>
    </form>
@endsection
