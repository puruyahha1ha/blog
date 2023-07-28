@extends('layouts.templete')
@section('title', '商品レビュー詳細')
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
    <p>商品レビュー詳細</p>
    <a href="/admin/review/list">一覧へ戻る</a>
@endsection
@section('main')

    {{-- 商品情報 --}}
    <div class="product_detail">
        {{-- 写真 --}}
        @for ($i = 1; $i <= 4; $i++)
            @php
                $colum_name = "image_$i";
            @endphp
            @if (is_null($product->$colum_name))
                @if ($colum_name == 'image_4')
                    <div class="empty" style="width: 200px; height: 200px; margin: 20px;">no image</div>
                @endif
                @continue
            @else
                <img src="{{ asset($product->$colum_name) }}" style="width: 200px; height: 200px; margin: 20px;">
                @break
            @endif
        @endfor

        {{-- 商品ID・商品名・評価 --}}
        <div class="product_text">
            <p>商品ID　　{{ $product->id }}</p>
            <p>{{ $product->name }}</p>
            <span>総合評価
                @if (!empty($avg_evaluation))
                    @foreach (Config('master.stars') as $key => $star)
                        @if ($key == ceil($avg_evaluation))
                            {{ $star }}　{{ $key }}
                        @endif
                    @endforeach
                @else
                    評価なし
                @endif
            </span>
        </div>
    </div>


    {{-- ID --}}
    <div class="form_row">
        <p>商品レビューID</p>
        <p>{{ $review->id }}</p>
    </div>

    {{-- 会員 --}}
    <div class="form_row">
        <p>会員</p>
        <p>{{ $member->name_sei }}　{{ $member->name_mei }}</p>
    </div>

    {{-- 商品評価 --}}
    <div class="form_row">
        <p>商品評価</p>
        <p>{{ $review->evaluation }}</p>
    </div>

    {{-- 商品コメント --}}
    <div class="form_row">
        <p>商品コメント</p>
        <p>{{ $review->comment }}</p>
    </div>

    {{-- 送信 --}}
    <div class="detail_buttons" style="display: flex; justify-content: space-around;">
        <a href="{{ route('admin.review.edit', ['id' => request()->query('id')]) }}">編集</a>
        <form id="delete" action="{{ route('admin.review.detail.delete') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ request()->query('id') }}">
            <input type="submit" value="削除">
        </form>
    </div>

@endsection
