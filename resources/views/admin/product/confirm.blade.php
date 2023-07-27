@extends('layouts.templete')
@if ($inputs['from'] == 'regist')
    @section('title', '商品登録確認')
@else
    @section('title', '商品編集確認')
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
        <p>商品登録確認</p>
    @else
        <p>商品編集確認</p>
    @endif
    <a href="/admin/product">一覧へ戻る</a>
@endsection
@section('main')
    <form method="POST" action="{{ route('admin.product.complete') }}">
        @csrf

        {{-- ID --}}
        <div class="form_row">
            <p>商品ID</p>
            @if ($inputs['from'] == 'regist')
                <p>登録後に自動採番</p>
            @else
                <p>{{ $inputs['id'] }}</p>
                <input type="hidden" name="id" value="{{ $inputs['id'] }}">
            @endif
        </div>

        {{-- 会員名 --}}
        <div class="form_row">
            <p>会員名</p>
            <p>{{ $member_name->name_sei }}{{ $member_name->name_mei }}</p>
            <input type="hidden" name="member_id" value="{{ $inputs['member_id'] }}">
        </div>

        {{-- 商品名 --}}
        <div class="form_row">
            <p>商品名</p>
            <p>{{ $inputs['name'] }}</p>
            <input type="hidden" name="name" value="{{ $inputs['name'] }}">
        </div>

        {{-- 商品カテゴリ --}}
        <div class="form_row">
            <p>商品カテゴリ</p>
            <p>{{ $product_category_name->name }}>{{ $product_subcategory_name->name }}</p>
            <input type="hidden" name="product_category_id" value="{{ $inputs['product_category_id'] }}">
            <input type="hidden" name="product_subcategory_id" value="{{ $inputs['product_subcategory_id'] }}">
        </div>


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
                        @if (empty($inputs[$image_name]))
                            src="" style="margin-bottom: 10px" 
                        @else 
                            src="{{ $inputs[$image_name] }}" style="width: 250px; height: 250px; margin-bottom: 10px"
                        @endif
                    >
                    <input type="hidden" value="{{ $inputs[$image_name] }}" name="image_{{ $i }}">
                @endfor
            </div>
        </div>

        {{-- 商品説明 --}}
        <div class="form_row">
            <p>商品説明</p>
            <p>{{ $inputs['product_content'] }}</p>
            <input type="hidden" name="product_content" value="{{ $inputs['product_content'] }}">
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
