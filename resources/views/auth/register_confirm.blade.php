@extends('layouts.templete')
@section('title', '会員登録確認画面')
@section('main')
    <h1>会員情報確認画面</h1>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        {{-- 氏名 --}}
        <div class="name">
            <p>氏名</p>
            <p>{{ $inputs['name_sei'] }}　{{ $inputs['name_mei'] }}</p>
            <input type="hidden" name="name_sei" value="{{ $inputs['name_sei'] }}">
            <input type="hidden" name="name_mei" value="{{ $inputs['name_mei'] }}">
        </div>
        {{-- ニックネーム --}}
        <div class="form_row">
            <p>ニックネーム</p>
            <p>{{ $inputs['nickname'] }}</p>
            <input type="hidden" name="nickname" value="{{ $inputs['nickname'] }}">
        </div>
        {{-- 性別 --}}
        <div class="gender">
            <p>性別</p>
            <p>
                @if ($inputs['gender'] == 1)
                    男性
                @else
                    女性
                @endif
            </p>
            <input type="hidden" name="gender" value="{{ $inputs['gender'] }}">
        </div>
        {{-- パスワード --}}
        <div class="form_row">
            <p>パスワード</p>
            <p>セキュリティのため非表示</p>
            <input type="hidden" name="password" value="{{ $inputs['password'] }}">
        </div>
        {{-- メールアドレス --}}
        <div class="form_row">
            <p>メールアドレス</p>
            <p class="emial_color">{{ $inputs['email'] }}</p>
            <input type="hidden" name="email" value="{{ $inputs['email'] }}">
        </div>
        {{-- 送信 --}}
        <div class="button">
            <input type="submit" name="confirm" value="登録完了" class="submit">
        </div>
    </form>

    <div class="button">
        <a href="/" class="submit_re" style="margin-top: 0px">トップに戻る</a>
    </div>

@endsection
