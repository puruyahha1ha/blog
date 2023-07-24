
{{-- @dd($inputs) --}}
@extends('layouts.templete')
@section('title', '商品レビュー編集確認')
@section('header_class', 'login_header')
@section('header')
    <p>商品レビュー編集確認</p>
    <a href="/">トップに戻る</a>
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

        {{-- 商品名・評価 --}}
        <div class="product_text">
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

    {{-- 登録フォーム --}}
    <form action="{{ route('mypage.control.complete') }}" method="post">
        @csrf
        <div class="regist_form">
            {{-- 商品評価 --}}
            <div class="form_row">
                <p>商品評価</p>
                <p>{{ $inputs['evaluation'] }}</p>
                <input type="hidden" name="evaluation" value="{{ $inputs['evaluation'] }}">
            </div>

            {{-- 商品コメント --}}
            <div class="form_row_comment">
                <p>商品コメント</p>
                <p>{{ $inputs['comment'] }}</p>
                <input type="hidden" name="comment" value="{{ $inputs['comment'] }}">
            </div>

            <input type="hidden" name="id" value="{{ $inputs['id'] }}">

            {{-- 更新ボタン --}}
            <div class="button">
                <input type="submit" value="更新する" class="list_submit">
            </div>
    
        </div>
    </form>

    <div class="detail_button_re">
        <button onClick="history.back();">前に戻る</button>
    </div>

@endsection
