@extends('layouts.templete')
@section('title', '会員詳細')
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
    <p>会員詳細</p>
    <a href="/admin/list">一覧へ戻る</a>
@endsection
@section('main')

    {{-- ID --}}
    <div class="form_row">
        <p>ID</p>
        <p>{{ $member->id }}</p>
    </div>

    {{-- 氏名 --}}
    <div class="name">
        <p>氏名</p>
        <p>{{ $member->name_sei }}　{{ $member->name_mei }}</p>
    </div>
    {{-- ニックネーム --}}
    <div class="form_row">
        <p>ニックネーム</p>
        <p>{{ $member->nickname }}</p>
    </div>
    {{-- 性別 --}}
    <div class="gender">
        <p>性別</p>
        <p>
            @if ($member->gender == 1)
                男性
            @else
                女性
            @endif
        </p>
    </div>
    {{-- パスワード --}}
    <div class="form_row">
        <p>パスワード</p>
        <p>セキュリティのため非表示</p>
    </div>
    {{-- メールアドレス --}}
    <div class="form_row">
        <p>メールアドレス</p>
        <p class="emial_color">{{ $member->email }}</p>
    </div>

    {{-- 送信 --}}
    <div class="detail_buttons" style="display: flex; justify-content: space-around;">
        <a href="{{ route('admin.list.edit', ['id' => $member->id]) }}" >編集</a>
        <form id="delete" action="{{ route('admin.list.detail.delete') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $member->id }}">
            <input type="submit" value="削除">
        </form>

    </div>


@endsection
