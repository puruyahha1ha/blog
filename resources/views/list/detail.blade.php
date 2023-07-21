@extends('layouts.templete')
@section('title', '商品詳細画面')
@section('head')
    <style>
        body {
            align-items: flex-start;
        }

        main {
            margin: 20px 10%;
        }
    </style>
@endsection
@section('header_class', 'login_header')
@section('header')
    <p>商品詳細</p>
    <a href="/">トップに戻る</a>
@endsection
@section('main')

    {{-- カテゴリ --}}
    <p>{{ $product->main_name }}>{{ $product->sub_name }}</p>

    {{-- 商品名・更新日時 --}}
    <div class="detail_row">
        <h2>{{ $product->name }}</h2>
        <p class="date">更新日時：{{ $product->updated_at }}</p>
    </div>

    {{-- 写真 --}}
    <div class="detail_row">
        @for ($i = 1; $i <= 4; $i++)
            @php
                $colum_name = "image_$i";
            @endphp
            @if ($product->$colum_name)
                <img src="{{ asset($product->$colum_name) }}" style="width: 200px; height: 200px">
            @endif
        @endfor
    </div>

    {{-- 商品説明 --}}
    <div class="detail_row_colum">
        <p>■商品説明</p>
        <p>{{ $product->product_content }}</p>
    </div>

    {{-- 商品レビュー --}}
    <div class="detail_row_colum">
        <p>■商品レビュー</p>
        <p>総合評価　
            @foreach (Config('master.stars') as $key => $star)
                @if ($key == ceil($avg_evaluation))
                    {{ $star }}　{{ $key }}
                @endif
            @endforeach
        </p>
        <a href="{{ route('list.review', ['id' => $product->id]) }}">＞＞レビューを見る</a>
    </div>

    @auth
        {{-- レビュー登録 --}}
        <div class="detail_button">
            <a href="{{ route('list.register', ['id' => $product->id]) }}">この商品についてのレビューを登録</a>
        </div>

    @endauth
    {{-- 戻る --}}
    <div class="detail_button">
        @if (!empty(request()->query('status')))
            <button onclick="history.back()">商品一覧に戻る</button>
        @else
            <a href="{{ route('list') }}" class="button">商品一覧に戻る</button>
        @endif
    </div>

@endsection
