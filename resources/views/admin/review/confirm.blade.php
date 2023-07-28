@extends('layouts.templete')
@if ($inputs['from'] == 'regist')
    @section('title', '商品レビュー登録確認')
@else
    @section('title', '商品レビュー編集確認')
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
        <p>商品レビュー登録確認</p>
    @else
        <p>商品レビュー編集確認</p>
    @endif
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


    <form method="POST" action="{{ route('admin.review.complete') }}">
        @csrf

        {{-- ID --}}
        <div class="form_row">
            <p>商品レビューID</p>
            @if ($inputs['from'] == 'regist')
                <p>登録後に自動採番</p>
            @else
                <p>{{ $inputs['id'] }}</p>
                <input type="hidden" name="id" value="{{ $inputs['id'] }}">
            @endif
        </div>

        {{-- 会員 --}}
        <div class="form_row">
            <p>会員</p>
            <p>{{ $member->name_sei }}　{{ $member->name_mei }}</p>
            <input type="hidden" name="member_id" value="{{ $inputs['member_id'] }}">
        </div>

        {{-- 商品評価 --}}
        <div class="form_row">
            <p>商品評価</p>
            <p>{{ $inputs['evaluation'] }}</p>
            <input type="hidden" name="evaluation" value="{{ $inputs['evaluation'] }}">
        </div>

        {{-- 商品コメント --}}
        <div class="form_row">
            <p>商品コメント</p>
            <p>{{ $inputs['comment'] }}</p>
            <input type="hidden" name="comment" value="{{ $inputs['comment'] }}">
        </div>

        <input type="hidden" name="product_id" value="{{ $inputs['name'] }}">
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
