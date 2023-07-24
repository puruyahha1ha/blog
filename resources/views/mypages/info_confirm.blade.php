@extends('layouts.templete')
@section('title', '会員情報変更確認画面')
@section('header')
    <style>
        header {
            display: none;
        }
    </style>
@endsection
@section('main')
    <h1>会員情報変更確認画面</h1>
    
    <form method="POST" action="{{ route('mypage.info.complete') }}">
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

        {{-- 送信 --}}
        <div class="button">
            <input type="submit" name="confirm" value="登録完了" class="submit">
        </div>

    </form>

    <div class="button">
        <button onClick="history.back();" class="submit_re" style="margin-top: 0px">前に戻る</button>
    </div>

@endsection