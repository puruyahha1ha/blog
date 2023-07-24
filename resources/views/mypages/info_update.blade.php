@extends('layouts.templete')
@section('title', '会員情報変更画面')
@section('header')
    <style>
        header {
            display: none;
        }
    </style>
@endsection
@section('main')
    <h1>会員情報登録</h1>

    <form action="{{ route('mypage.info.confirm') }}" method="post">
        @csrf
        <div class="regist_form">

            {{-- 氏名 --}}
            <div class="name">
                <p>氏名</p>
                <span>姓</span>
                <input type="text" name="name_sei" value="@if (old('name_sei')){{ old('name_sei') }}@else{{ Auth::user()->name_sei }}@endif">
                <span>名</span>
                <input type="text" name="name_mei" value="@if (old('name_mei')){{ old('name_mei') }}@else{{ Auth::user()->name_mei }}@endif">
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
                <input type="text" name="nickname" value="@if (old('nickname')){{ old('nickname') }}@else{{ Auth::user()->nickname }}@endif">
            </div>

            {{-- ニックネームのエラーメッセージ --}}
            @error('nickname')
                <div class="error">{{ $message }}</div>
            @enderror

            {{-- 性別 --}}
            <div class="gender">
                <p>性別</p>
                @foreach (Config('master.gender') as $key => $value)
                    <input type="radio" name="gender" value="{{ $key }}" id="{{ $value }}" @if (old('gender') == $key) checked @elseif (Auth::user()->gender == $key) checked @else @endif>
                    <label for="{{ $value }}">{{ $value }}</label>
                @endforeach
            </div>

            {{-- 性別のエラーメッセージ --}}
            @error('gender')
                <div class="error">{{ $message }}</div>
            @enderror

        </div>

        {{-- 確認画面へ --}}
        <div class="button">
            <input type="submit" value="確認画面へ" class="submit">
        </div>

    </form>

    {{-- マイページに戻る --}}
    <div class="button">
        <a href="{{ route('mypage') }}" class="submit_re" style="margin-top: 0px">マイページに戻る</a>
    </div>

@endsection
