@extends('layouts.templete')
@if ($inputs['from'] == 'regist')
    @section('title', '会員登録')
@else
    @section('title', '会員編集')
@endif
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
    @if ($inputs['from'] == 'regist')
        <p>会員登録</p>
    @else
        <p>会員編集</p>
    @endif
    <a href="/admin/list">一覧へ戻る</a>
@endsection
@section('main')
    <h1>会員情報確認画面</h1>

    <form method="POST" action="{{ route('admin.list.complete') }}">
        @csrf

        {{-- ID --}}
        <div class="form_row">
            <p>ID</p>
            @if ($inputs['from'] == 'regist')
                <p>登録後に自動採番</p>
            @else
                <p>{{ $inputs['id'] }}</p>
                <input type="hidden" name="id"
                    value="@if (old('id')) {{ old('id') }}@else{{ $inputs['id'] }} @endif">
            @endif
        </div>

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

        <input type="hidden" name="from" value="@if ($inputs['from'] == 'regist') regist @else edit @endif">

        {{-- 送信 --}}
        <div class="search_button">
            @if ($inputs['from'] == 'regist')
                <input type="submit" value="登録完了">
            @else
                <input type="submit" value="編集完了">
            @endif
        </div>

    </form>

    <div class="search_button">
        <button onClick="history.back();">前に戻る</button>
    </div>


@endsection
