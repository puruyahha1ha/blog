@extends('layouts.templete')
@section('title', '商品一覧')
@section('header_class', 'login_header')

@section('header')
    <p>商品一覧</p>
    @auth
        <a href="{{ route('product', ['from' => 'list']) }}">新規商品登録</a>
    @endauth
@endsection
@section('main')
    {{-- 検索フォーム --}}
    <form action="{{ route('list.search') }}" method="post" id="search_form">
        @csrf
        {{-- カテゴリ --}}
        <div class="form_row">
            <p>カテゴリ</p>

            {{-- メインのカテゴリ --}}
            <select name="product_category_id" id="category_id">
                <option value="0">選択してください</option>
                @foreach ($product_categories as $val)
                    @if ($val->id == old('product_category_id'))
                        <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                    @else
                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                    @endif
                @endforeach
            </select>

            {{-- サブのカテゴリ --}}
            <select name="product_subcategory_id" id="subcategory_id">
                @if (old('product_category_id'))
                    @foreach (Config('master.product_subcategory_id') as $key => $val)
                        @if ($key == old('product_category_id'))
                            @foreach ($val as $key_v => $val_v)
                                @if ($key_v == old('product_subcategory_id'))
                                    <option value="{{ $key_v }}" selected>{{ $val_v }}</option>
                                @else
                                    <option value="{{ $key_v }}">{{ $val_v }}</option>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </select>
        </div>

        {{-- フリーワード --}}
        <div class="form_row">
            <p>フリーワード</p>
            <input type="text" name="free_word" value="">
        </div>

        {{-- 検索 --}}
        <div class="button">
            <input type="submit" value="商品検索" class="serach_button">
        </div>
    </form>

    {{-- 商品一覧 --}}
    <div class="list">
        @foreach ($products as $val)
            <div class="list_row">
                {{-- 写真 --}}
                @for ($i = 1; $i <= 4; $i++)
                    @php
                        $culum_name = "image_$i";
                    @endphp
                    @if (is_null($val->$culum_name))
                        @if ($culum_name == 'image_4')
                            <div class="empty" style="width: 200px; height: 200px">no image</div>
                        @endif
                        @continue
                    @else
                        <img src="{{ asset($val->$culum_name) }}" style="width: 200px; height: 200px">
                        @break
                    @endif
                @endfor

                {{-- 商品情報 --}}
                <div class="information">
                    <p>{{ $val->main_name }}>{{ $val->sub_name }}</p>
                    <a href="">{{ $val->name }}</a>
                </div>

                {{-- 詳細 --}}
                <div class="detail">
                    <a href="{{ route('list.detail') }}">詳細</a>
                </div>
            </div>
        @endforeach

        {{-- ペジネーション --}}
        <div class="links">
            {{ $products->links() }}
        </div>
        
    </div>
    
    {{-- 戻る --}}
    <div class="button">
        <a href="/" class="submit_re">トップに戻る</a>
    </div>

    {{-- jsファイルの読み込み --}}
    <script src="{{ asset('js/script.js') }}"></script>

@endsection
