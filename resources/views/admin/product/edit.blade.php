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

        {{-- 会員名 --}}
        <div class="form_row">
            <p>会員名</p>
            <select name="member_id" id="">
                <option value="0">選択してください</option>
                @foreach ($members as $val)
                    @if (!empty($product))
                        @if ($val->id == old('member_id', $product->member_id))
                            <option value="{{ $val->id }}" selected>{{ $val->name_sei }}　{{ $val->name_mei }}</option>
                        @else
                            <option value="{{ $val->id }}">{{ $val->name_sei }}　{{ $val->name_mei }}</option>
                        @endif
                    @else
                        @if ($val->id == old('member_id'))
                            <option value="{{ $val->id }}" selected>{{ $val->name_sei }}　{{ $val->name_mei }}
                            </option>
                        @else
                            <option value="{{ $val->id }}">{{ $val->name_sei }}　{{ $val->name_mei }}</option>
                        @endif
                    @endif
                @endforeach

            </select>
        </div>

        {{-- 会員名のエラーメッセージ --}}
        @error('member_id')
            <div class="error">{{ $message }}</div>
        @enderror


        {{-- 商品名 --}}
        <div class="form_row">
            <p>商品名</p>
            <input type="text" name="name"
                @if (empty($product)) value="{{ old('name') }}" @else value="{{ old('name', $product->name) }}" @endif>
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
                    @if (!empty($product))
                        @if ($val->id == old('product_category_id', $product->product_category_id))
                            <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                        @else
                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endif
                    @else
                        @if ($val->id == old('product_category_id'))
                            <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                        @else
                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endif
                    @endif
                @endforeach
            </select>

            {{-- サブのカテゴリ --}}
            <select name="product_subcategory_id" id="subcategory_id">
                @if (!empty($product))
                    @foreach ($product_subcategories as $val)
                        @if (old('product_category_id') && old('product_category_id') == $val->product_category_id)
                            @if ($val->id == old('product_subcategory_id'))
                                <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                            @else
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                            @endif
                        @else
                            @if ($val->product_category_id == $product->product_category_id)
                                @if ($val->id == old('product_subcategory_id', $product->product_subcategory_id))
                                    <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                                @else
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endif
                            @endif
                        @endif
                    @endforeach
                @else
                    @foreach ($product_subcategories as $val)
                        @if (old('product_category_id') && old('product_category_id') == $val->product_category_id)
                            @if ($val->id == old('product_subcategory_id'))
                                <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                            @else
                                <option value="{{ $val->id }}">{{ $val->name }}</option>
                            @endif
                        @endif
                    @endforeach
                @endif
            </select>
        </div>

        {{-- 商品のメインカテゴリのエラーメッセージ --}}
        @error('product_category_id')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 商品のサブカテゴリのエラーメッセージ --}}
        @error('product_subcategory_id')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 商品写真 --}}
        <div class="form_row_img">
            <p>商品写真</p>
            <div class="img_block">
                @for ($i = 1; $i <= 4; $i++)
                    @php
                        $image_name = "image_$i";
                    @endphp
                    <p>写真{{ $i }}</p>
                    <img id="image_{{ $i }}_preview"
                        @if (empty($product->$image_name)) @if (old("image_$i")) 
                                src="{{ old("image_$i") }}"
                                style="width: 250px; height: 250px"
                            @else
                                src=""
                                style="" @endif
                    @else src="{{ old("image_$i", $product->$image_name) }}" style="width: 250px; height: 250px"
                        @endif
                    >
                    <label for="image_{{ $i }}">
                        <span class="upload_button">アップロード</span><input type="file" id="image_{{ $i }}"
                            accept="image/gif, image/png, image/jpeg">
                    </label>
                    <input type="hidden"
                        @if (!empty($product)) value="{{ old("image_$i", $product->$image_name) }}" @else value="{{ old("image_$i") }}" @endif
                        name="image_{{ $i }}" id="hi_image_{{ $i }}">
                @endfor
            </div>
        </div>

        {{-- 商品説明 --}}
        <div class="form_row_text">
            <p>商品説明</p>
            <textarea name="product_content" cols="50" rows="10">
@if (empty($product)){{ old('product_content') }}@else{{ old('product_content', $product->product_content) }}@endif
</textarea>
        </div>

        {{-- 商品名のエラーメッセージ --}}
        @error('product_content')
            <div class="error">{{ $message }}</div>
        @enderror

        <input type="hidden" name="from" value="@if (request()->query('id')) edit @else regist @endif">

        <div class="search_button">
            <input type="submit"　value="確認画面へ">
        </div>

    </form>

    {{-- jsファイルの読み込み --}}
    <script src="{{ asset('js/adminScript.js') }}"></script>

@endsection
