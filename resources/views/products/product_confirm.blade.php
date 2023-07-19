@extends('layouts.templete')
@section('title', '商品登録確認画面')
@section('main')
    <h1>商品登録確認画面</h1>

    <form action="{{ route('product.complete') }}" method="post">
        @csrf

        {{-- 商品名 --}}
        <div class="form_row">
            <p>商品名</p>
            <p>{{ $inputs['name'] }}</p>
            <input type="hidden" name="name" value="{{ $inputs['name'] }}">
        </div>

        {{-- 商品カテゴリ --}}
        <div class="form_row">
            <p>商品カテゴリ</p>
            {{-- メインカテゴリ --}}
            <select name="product_category_id" id="category_id">
                <option value="{{ $inputs['product_category_id'] }}">{{ $category_name[0]->name }}</option>
            </select>
            {{-- サブカテゴリ --}}
            <select name="product_subcategory_id" id="subcategory_id">
                <option value="{{ $inputs['product_subcategory_id'] }}">{{ $subcategory_name[0]->name }}</option>
            </select>
        </div>

        {{-- 商品写真 --}}
        <div class="form_row_img">
            <p>商品写真</p>
            <div class="img_block">

                {{-- 写真１ --}}
                @if ($inputs['image_1'])
                    <p>写真１</p>
                    <img src="{{ asset($inputs['image_1']) }}" style="width: 250px; height: 250px;">
                    <input type="hidden" name="image_1" value="{{ $inputs['image_1'] }}">
                @endif

                {{-- 写真２ --}}
                @if ($inputs['image_2'])
                    <p>写真２</p>
                    <img src="{{ asset($inputs['image_2']) }}" style="width: 250px; height: 250px;">
                    <input type="hidden" name="image_2" value="{{ $inputs['image_2'] }}">
                @endif

                {{-- 写真３ --}}
                @if ($inputs['image_3'])
                    <p>写真３</p>
                    <img src="{{ asset($inputs['image_3']) }}" style="width: 250px; height: 250px;">
                    <input type="hidden" name="image_3" value="{{ $inputs['image_3'] }}">
                @endif

                {{-- 写真４ --}}
                @if ($inputs['image_4'])
                    <p>写真４</p>
                    <img src="{{ asset($inputs['image_4']) }}" style="width: 250px; height: 250px;">
                    <input type="hidden" name="image_4" value="{{ $inputs['image_4'] }}">
                @endif
            </div>
        </div>

        {{-- 商品説明 --}}
        <div class="form_row">
            <p>商品説明</p>
            <p>{{ $inputs['product_content'] }}</p>
            <textarea name="product_content" style="display: none">{{ $inputs['product_content'] }}</textarea>
        </div>

        <div class="button">
            <input type="submit" value="商品を登録する" class="submit">
        </div>

        <div class="button">
            <input type="submit" value="前に戻る" class="submit" name="back" class="submit_re">
        </div>
    </form>

@endsection
