@extends('layouts.templete')
@section('title', '商品登録画面')
@section('main')
    <h1>商品登録</h1>
    <form method="POST" action="{{ route('product.confirm') }}" enctype="multipart/form-data">
        @csrf
        {{-- 商品名 --}}
        <div class="form_row">
            <p>商品名</p>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        {{-- 商品名のエラーメッセージ --}}
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 商品カテゴリ --}}
        <div class="form_row">
            <p>商品カテゴリ</p>

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

        {{-- 商品のメインカテゴリのエラーメッセージ --}}
        @error('product_category_id')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 商品のサブカテゴリのエラーメッセージ --}}
        @error('product_subcategory_id')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 商品写真 --}}
        <div class="form_row_img">
            <p>商品写真</p>
            <div class="img_block">

                <p>写真１</p>
                <img src="{{ old('image_1') }}" id="image_1_preview"
                    @if (old('image_1')) style="width: 250px; height: 250px;" @else style="" @endif>
                <label for="image_1">
                    <span class="upload_button">アップロード</span><input type="file" id="image_1"
                        accept="image/gif, image/png, image/jpeg">
                </label>
                <input type="hidden" value="{{ old('image_1') }}" name="image_1" id="hi_image_1">

                <p>写真２</p>
                <img src="{{ old('image_2') }}" id="image_2_preview"
                    @if (old('image_2')) style="width: 250px; height: 250px;" @else style="" @endif>
                <label for="image_2">
                    <span class="upload_button">アップロード</span><input type="file" id="image_2"
                        accept="image/gif, image/png, image/jpeg">
                </label>
                <input type="hidden" value="{{ old('image_2') }}" name="image_2" id="hi_image_2">

                <p>写真３</p>
                <img src="{{ old('image_3') }}" id="image_3_preview"
                    @if (old('image_3')) style="width: 250px; height: 250px;" @else style="" @endif>
                <label for="image_3">
                    <span class="upload_button">アップロード</span><input type="file" id="image_3"
                        accept="image/gif, image/png, image/jpeg">
                </label>
                <input type="hidden" value="{{ old('image_3') }}" name="image_3" id="hi_image_3">

                <p>写真４</p>
                <img src="{{ old('image_4') }}" id="image_4_preview"
                    @if (old('image_4')) style="width: 250px; height: 250px;" @else style="" @endif>
                <label for="image_4">
                    <span class="upload_button">アップロード</span><input type="file" id="image_4"
                        accept="image/gif, image/png, image/jpeg">
                </label>
                <input type="hidden" value="{{ old('image_4') }}" name="image_4" id="hi_image_4">

            </div>
        </div>

        {{-- 商品説明 --}}
        <div class="form_row_text">
            <p>商品説明</p>
            <textarea name="product_content" cols="50" rows="20">{{ old('product_content') }}</textarea>
        </div>

        {{-- 商品名のエラーメッセージ --}}
        @error('product_content')
            <div class="error">{{ $message }}</div>
        @enderror


        <div class="button">
            <input type="submit" value="確認画面へ" class="submit">
        </div>
    </form>

    <div class="button">
        <a href="/" class="submit_re" style="margin-top: 0px">トップに戻る</a>
    </div>

    {{-- jsファイルの読み込み --}}
    <script src="{{ asset('js/script.js') }}"></script>
@endsection
