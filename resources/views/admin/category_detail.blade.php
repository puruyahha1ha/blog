@extends('layouts.templete')
@section('title', '商品カテゴリ詳細')
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
    <p>商品カテゴリ詳細</p>
    <a href="/admin/category_list">一覧へ戻る</a>
@endsection
@section('main')

    {{-- ID --}}
    <div class="form_row">
        <p>商品大カテゴリID</p>
        <p>{{ $product_category->id }}</p>
    </div>

    {{-- 商品大カテゴリ --}}
    <div class="form_row">
        <p>商品大カテゴリ</p>
        <p>{{ $product_category->name }}</p>
    </div>

    {{-- 商品小カテゴリ --}}
    <div class="form_row" style="height: auto">
        <p>商品小カテゴリ</p>
        <div class="inputs">

            @for ($i = 1; $i <= 10; $i++)
                {{-- 小カテゴリ --}}
                <p style="margin-bottom: 10px">@if(!empty($product_subcategory[$i - 1])){{ $product_subcategory[$i - 1]->name }}@endif</p>
            @endfor

        </div>
    </div>

    {{-- 送信 --}}
    <div class="detail_buttons" style="display: flex; justify-content: space-around;">
        <a href="{{ route('admin.category_list.edit', ['id' => $product_category->id]) }}">編集</a>
        <form id="delete" action="{{ route('admin.category_list.detail.delete') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $product_category->id }}">
            <input type="submit" value="削除">
        </form>

    </div>


@endsection
