@extends('layouts.templete')
@section('title', '商品登録・編集')
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
        <p>商品編集</p>
    @else
        <p>商品登録</p>
    @endif
    <a href="/admin/product/list">一覧へ戻る</a>
@endsection
@section('main')
    <form action="{{ route('admin.product.confirm') }}" method="post">
        @csrf

        {{-- ID --}}
        <div class="form_row">
            <p>ID</p>
            @if (!empty($product))
                <p>{{ $product->id }}</p>
                <input type="hidden" name="id"
                    value="@if (old('id')) {{ old('id') }}@else{{ $product->id }} @endif">
            @else
                <p>登録後に自動採番</p>
            @endif
        </div>

        {{-- 商品名 --}}
        <div class="form_row">
            <p>商品名</p>
            <input type="text" name="name"
                value="@if (empty($product)) @elseif(old('name')){{ old('name') }}@else{{ $product->name }} @endif">
        </div>

        {{-- 商品名のエラーメッセージ --}}
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 商品カテゴリ --}}
        <div class="form_row">
            <p>商品カテゴリ</p>

            {{-- メインのカテゴリ --}}
            <select name="product_category_id" id="category_id">
                <option value="0">選択してください</option>
                @foreach ($product_categories as $val)
                    @if ($val->id == old('product_category_id'))
                        <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                    @else
                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                    @endif
                @endforeach
            </select>

            {{-- サブのカテゴリ --}}
            <select name="product_subcategory_id" id="subcategory_id"></select>
        </div>


        <div class="form_row" style="height: auto">
            <p>商品小カテゴリ</p>
            <div class="inputs">

                @for ($i = 1; $i <= 10; $i++)
                    {{-- 小カテゴリ --}}
                    <input type="text" name="sub_name{{ $i }}"
                        value="@if (empty($product_subcategory[$i - 1])) @elseif(old("sub_name$i")){{ old("sub_name$i") }}@else{{ $product_subcategory[$i - 1]->name }} @endif"
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

    {{-- jsファイルの読み込み --}}
    <script src="{{ asset('js/adminScript.js') }}"></script>

@endsection
