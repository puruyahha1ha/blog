@extends('layouts.templete')
@section('title', '商品レビュー登録完了画面')
@section('header_class', 'login_header')
@section('header')
    <p>商品レビュー登録完了</p>
    <a href="/">トップに戻る</a>
@endsection
@section('main')
    <p>商品レビューの登録が完了しました。</p>


    {{-- 商品レビュー一覧へ --}}
    <div class="detail_button">
        <a href="{{ route('list.review', ['id' => $id]) }}">商品レビュー一覧へ</a>
    </div>

    {{-- 商品詳細へ --}}
    <div class="detail_button_re">
        <a href="{{ route('list.detail', ['id' => $id]) }}">商品詳細に戻る</a>
    </div>

@endsection
