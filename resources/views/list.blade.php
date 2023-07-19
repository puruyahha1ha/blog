@extends('layouts.templete')
@section('title', '商品一覧')
@section('header_class', 'login_header')

@section('header')
    <p>商品一覧</p>
    @auth
        <a href="{{ route('product') }}">新規商品登録</a>
    @endauth
@endsection
@section('main')
    {{-- 検索フォーム --}}
    <form action="" method="post">
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

    <div class="button">
        <a href="/" class="submit_re">トップに戻る</a>
    </div>

    {{-- jsファイルの読み込み --}}
    <script src="{{ asset('js/script.js') }}"></script>

@endsection
