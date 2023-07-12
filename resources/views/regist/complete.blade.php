@extends('layouts.templete')
@section('title', '登録完了画面')
@section('main')
    <h1>会員登録完了</h1>
    <p>会員登録が完了しました。</p>
    {{-- 戻る --}}
    <div class="button">
        <a href="{{ route('top') }}" class="submit">トップに戻る</a>
    </div>
@endsection