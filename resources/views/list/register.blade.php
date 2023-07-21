@extends('layouts.templete')
@section('title', 'レビュー登録画面')
@section('header_class', 'login_header')
@section('header')
    <p>商品レビュー登録</p>
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
<form action="{{ route('review.confirm') }}" method="post">
    @csrf
    <div class="regist_form">
        {{-- 商品評価 --}}
        <div class="form_row">
            <p>商品評価</p>
            <select name="evaluation" id="evaluation">
                @for ($i = 5; $i > 0; $i--)
                    @if ($i == old('evaluation'))
                        <option value="{{ $i }}" selected>　　{{ $i }}　　</option>
                    @else
                        <option value="{{ $i }}">　　{{ $i }}　　</option>
                    @endif
                @endfor
            </select>
        </div>

        {{-- 商品評価のエラーメッセージ --}}
        @error('evaluation')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 商品コメント --}}
        <div class="form_row_comment">
            <p>商品コメント</p>
            <textarea name="comment" id="" cols="50" rows="10">{{ old('comment') }}</textarea>
        </div>

        {{-- 商品コメントのエラーメッセージ --}}
        @error('comment')
            <div class="error">{{ $message }}</div>
        @enderror


        <input type="hidden" name="id" value="{{ $product->id }}">
        {{-- 確認ボタン --}}
        <div class="button">
            <input type="submit" value="商品レビュー登録確認" class="list_submit">
        </div>

    </div>
</form>

<div class="detail_button_re">
    <button onClick="history.back();">商品詳細に戻る</button>
</div>

@endsection
