@extends('layouts.templete')
@section('title', '商品詳細')
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
    <p>商品詳細</p>
    <a href="/admin/product/list">一覧へ戻る</a>
@endsection
@section('main')

    {{-- ID --}}
    <div class="form_row">
        <p>商品ID</p>
        @if ($product->from == 'regist')
            <p>登録後に自動採番</p>
        @else
            <p>{{ $product->id }}</p>
            <input type="hidden" name="id" value="{{ $product->id }}">
        @endif
    </div>

    {{-- 会員名 --}}
    <div class="form_row">
        <p>会員名</p>
        <p>{{ $product->name_sei }}　{{ $product->name_mei }}</p>
        <input type="hidden" name="member_id" value="{{ $product->member_id }}">
    </div>

    {{-- 商品名 --}}
    <div class="form_row">
        <p>商品名</p>
        <p>{{ $product->name }}</p>
        <input type="hidden" name="name" value="{{ $product->name }}">
    </div>

    {{-- 商品カテゴリ --}}
    <div class="form_row">
        <p>商品カテゴリ</p>
        <p>{{ $product->main_name }}>{{ $product->sub_name }}</p>
        <input type="hidden" name="product_category_id" value="{{ $product->product_category_id }}">
        <input type="hidden" name="product_subcategory_id" value="{{ $product->product_subcategory_id }}">
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
                    @if (empty($product->$image_name)) src="" style="margin-bottom: 10px" 
                        @else 
                            src="{{ $product->$image_name }}" style="width: 250px; height: 250px; margin-bottom: 10px" @endif>
                <input type="hidden" value="{{ $product->$image_name }}" name="image_{{ $i }}">
            @endfor
        </div>
    </div>

    {{-- 商品説明 --}}
    <div class="form_row">
        <p>商品説明</p>
        <p>{{ $product->product_content }}</p>
        <input type="hidden" name="product_content" value="{{ $product->product_content }}">
    </div>


    {{-- 総合評価 --}}
    <div class="form_row" style="background-color: gray">
        <p>総合評価</p>
        @if (!empty($average))
            @foreach (Config('master.stars') as $key => $star)
                @if ($key == ceil($average))
                    {{ $star }}　{{ $key }}
                @endif
            @endforeach
        @else
            評価なし
        @endif
    </div>

    @if (!empty($reviews[0]))
        @foreach ($reviews as $val)
            <div class="review_block" style="border-bottom: black solid 1px">
                <div class="form_row">
                    <p>商品レビュー</p>
                    <p>{{ $val->id }}</p>
                </div>
                <div class="form_row">
                    <a href="{{ route('admin.list.detail', ['id' => $val->member_id]) }}"
                        style="color: blue; text-decoration: none; width: 200px; margin-right: 20px">{{ $val->name_mei }}さん</a>
                    @foreach (Config('master.stars') as $key => $star)
                        @if ($key == $val->evaluation)
                            {{ $star }}　{{ $key }}
                        @endif
                    @endforeach
                </div>
                <div class="form_row">
                    <p>商品コメント</p>
                    <p>
                        @if (mb_strlen($val->comment) > 16)
                            {{ mb_substr($val->comment, 0, 16) }}...
                        @else
                            {{ $val->comment }}
                        @endif
                    </p>
                    <a href="" style="border: black solid 1px; text-decoration: none; color: black">商品レビュー詳細</a>
                </div>
            </div>
        @endforeach

    @else
            <p>レビューはありません</p>
    @endif

    {{-- ペジネーション --}}
    <div class="links">
        {{ $reviews->appends(request()->query())->links() }}
    </div>


    {{-- 送信 --}}
    <div class="detail_buttons" style="display: flex; justify-content: space-around;">
        <a href="{{ route('admin.product.edit', ['id' => request()->query('id')]) }}">編集</a>
        <form id="delete" action="{{ route('admin.product.detail.delete') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ request()->query('id') }}">
            <input type="submit" value="削除">
        </form>
    </div>

@endsection
