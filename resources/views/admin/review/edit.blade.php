@extends('layouts.templete')
@section('title', '商品レビュー登録・編集')
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
    @if (request()->query('id'))
        <p>商品レビュー編集</p>
    @else
        <p>商品レビュー登録</p>
    @endif
    <a href="/admin/review/list">一覧へ戻る</a>
@endsection
@section('main')
    <form action="{{ route('admin.review.confirm') }}" method="post">
        @csrf

        {{-- 商品 --}}
        <div class="form_row">
            <p>商品</p>
            <select name="name">
                <option value="0">選択してください</option>
                @foreach ($products as $val)
                    @if (!empty($review))
                        @if ($val->id == old('name', $review->product_id))
                            <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                        @else
                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endif
                    @else
                        @if ($val->id == old('name'))
                            <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                        @else
                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endif
                    @endif
                @endforeach
            </select>
        </div>

        {{-- 商品のエラーメッセージ --}}
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 会員 --}}
        <div class="form_row">
            <p>会員</p>
            <select name="member_id">
                <option value="0">選択してください</option>
                @foreach ($members as $val)
                    @if (!empty($review))
                        @if ($val->id == old('member_id', $review->member_id))
                            <option value="{{ $val->id }}" selected>{{ $val->name_sei }}　{{ $val->name_mei }}</option>
                        @else
                            <option value="{{ $val->id }}">{{ $val->name_sei }}　{{ $val->name_mei }}</option>
                        @endif
                    @else
                        @if ($val->id == old('member_id'))
                            <option value="{{ $val->id }}" selected>{{ $val->name_sei }}　{{ $val->name_mei }}</option>
                        @else
                            <option value="{{ $val->id }}">{{ $val->name_sei }}　{{ $val->name_mei }}</option>
                        @endif
                    @endif
                @endforeach
            </select>
        </div>

        {{-- 商品のエラーメッセージ --}}
        @error('member_id')
            <div class="error">{{ $message }}</div>
        @enderror


        {{-- ID --}}
        <div class="form_row">
            <p>ID</p>
            @if (!empty($review))
                <p>{{ $review->id }}</p>
                <input type="hidden" name="id"
                    value="@if (old('id')) {{ old('id') }}@else{{ $review->id }} @endif">
            @else
                <p>登録後に自動採番</p>
            @endif
        </div>

        {{-- 商品評価 --}}
        <div class="form_row">
            <p>商品評価</p>
            <select name="evaluation">
                @for ($i = 5; $i >= 1; $i--)
                    @if (!empty($review))
                        @if ($i == old('evaluation', $review->evaluation))
                            <option value="{{ $i }}" selected>{{ $i }}　　　</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}　　　</option>
                        @endif
                    @else
                        @if ($i == old('evaluation'))
                            <option value="{{ $i }}" selected>{{ $i }}　　　</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}　　　</option>
                        @endif
                    @endif
                @endfor
            </select>
        </div>

        {{-- 商品評価のエラーメッセージ --}}
        @error('evaluation')
            <div class="error">{{ $message }}</div>
        @enderror

        {{-- 商品コメント --}}
        <div class="form_row_text">
            <p>商品コメント</p>
            @if (empty($review))
                <textarea name="comment" cols="50" rows="10">{{ old('comment') }}</textarea>
            @else
                <textarea name="comment" cols="50" rows="10">{{ old('comment', $review->comment) }}</textarea>
            @endif

        </div>

        {{-- 商品コメントのエラーメッセージ --}}
        @error('comment')
            <div class="error">{{ $message }}</div>
        @enderror

        <input type="hidden" name="from" value="@if (request()->query('id')) edit @else regist @endif">

        <div class="search_button_re">
            <input type="submit" value="確認画面へ">
        </div>

    </form>

@endsection
