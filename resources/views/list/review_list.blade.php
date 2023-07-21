{{-- @dd($product) --}}
@extends('layouts.templete')
@section('title', 'レビュー一覧')
@section('header_class', 'login_header')
@section('header')
    <p>商品レビュー一覧</p>
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
                <span>総合評価　{{ ceil($avg_evaluation) }}</span>
            </div>
    
        </div>

        {{-- レビュー一覧 --}}
        <div class="review_list">
            @foreach ($reviews as $val)
                <div class="review_row">
                    
                    {{-- レビュー情報 --}}
                    <div class="review_information">
                        <p>{{ $val->member_name }}</p>
                        @foreach (Config('master.stars') as $key => $star)
                            @if ($key == $val->evaluation)
                                <p>{{ $star }}　{{ $key }}</p>
                            @endif
                        @endforeach
                    </div>
    
                    {{-- 商品コメント --}}
                    <div class="product_comment">
                        <p>商品コメント</p>
                        <p>{{ $val->comment }}</p>
                    </div>
                </div>
            @endforeach
    
            {{-- ペジネーション --}}
            <div class="links">
                {{ $reviews->appends(['id' => $product->id])->links() }}
            </div>
            
        </div>

        {{-- 商品詳細へ --}}
        <div class="detail_button_re">
            <a href="{{ route('list.detail', ['id' => $product->id]) }}">商品詳細に戻る</a>
        </div>

    
    
@endsection
