@extends('layouts.templete')
@section('title', '商品カテゴリ登録・編集')
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
    @if (request()->query('id'))
        <p>商品カテゴリ編集</p>
    @else
        <p>商品カテゴリ登録</p>
    @endif
    <a href="/admin/category_list">一覧へ戻る</a>
@endsection
@section('main')
    <form action="{{ route('admin.category_list.confirm') }}" method="post">
        @csrf

        {{-- ID --}}
        <div class="form_row">
            <p>商品大カテゴリID</p>
            @if (!empty($product_category))
                <p>{{ $product_category->id }}</p>
                <input type="hidden" name="id" value="{{ old('id', $product_category->id) }}">
            @else
                <p>登録後に自動採番</p>
            @endif
        </div>

        {{-- 商品大カテゴリ --}}
        <div class="form_row">
            <p>商品大カテゴリ</p>
            <input type="text" name="name"
                @if (!empty($product_category)) value="{{ old('name', $product_category->name) }}"@else value="{{ old('name') }}" @endif>
        </div>

        {{-- 商品大カテゴリのエラーメッセージ --}}
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 商品小カテゴリ --}}
        <div class="form_row" style="height: auto">
            <p>商品小カテゴリ</p>
            <div class="inputs">

                @for ($i = 1; $i <= 10; $i++)
                    {{-- 小カテゴリ --}}
                    <input type="text" name="sub_name{{ $i }}"
                        @if (empty($product_subcategory[$i - 1])) value="{{ old("sub_name$i") }}" 
                        @else 
                            value="{{ old("sub_name$i", $product_subcategory[$i - 1]->name) }}" @endif
                        style="margin-bottom: 10px">
                    {{-- 小カテゴリのエラーメッセージ --}}
                    @error("sub_name$i")
                        <div class="error" style="margin: 10px 0">{{ $message }}</div>
                    @enderror
                @endfor

            </div>
        </div>

        <input type="hidden" name="from" value="@if (request()->query('id')) edit @else regist @endif">

        <div class="search_button">
            <input type="submit" name="confirm" value="確認画面へ">
        </div>

    </form>
@endsection
