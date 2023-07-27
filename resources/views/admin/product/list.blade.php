@extends('layouts.templete')
@section('title', '商品一覧')
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
    <p>商品一覧</p>
    <a href="/admin">トップへ戻る</a>
@endsection
@section('main')

    <a href="{{ route('admin.product.edit') }}" class="list_regist">商品登録</a>
    <form action="{{ route('admin.product.list') }}" method="get">
        {{-- 検索フォーム --}}
        <div class="search_form">
            {{-- ID --}}
            <div class="search_row">
                <p>ID</p>
                <input type="text" name="id" value="{{ old('name') }}">
            </div>

            {{-- フリーワード --}}
            <div class="search_row">
                <p>フリーワード</p>
                <input type="text" name="free_word" value="{{ old('free_word') }}">
            </div>

        </div>

        <div class="search_button">
            <input type="submit" value="検索する">
        </div>
    </form>

    {{-- 商品一覧 --}}
    <table>
        <thead>
            <tr>
                <th style="text-decoretion: none">@sortablelink('id', 'ID ▼')</th>
                <th style="width: 250px">商品名</th>
                <th style="width: 150px">@sortablelink('created_at', '登録日時 ▼')</th>
                <th style="width: 80px; border: black solid 1px; border-bottom: none;">編集</th>
                <th style="width: 80px; border: black solid 1px; border-bottom: none;">詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $val)
                <tr>
                    <th>{{ $val->id }}</th>
                    <th><a href="{{ route('admin.product.detail', ['id' => $val->id]) }}"
                            style="text-decoration: none; color:blue">{{ $val->name }}</a>
                    </th>
                    <th>
                        @if ($val->created_at != null)
                            {{ $val->created_at->format('Y/m/d') }}
                        @endif
                    </th>
                    <th style="border-left:black solid 1px"><a href="{{ route('admin.product.edit', ['id' => $val->id]) }}"
                            style="text-decoration: none; color:blue">編集</a></th>
                    <th style="border-left:black solid 1px"><a href="{{ route('admin.product.detail', ['id' => $val->id]) }}"
                            style="text-decoration: none; color:blue">詳細</a></th>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ペジネーション --}}
    <div class="links">
        {{ $products->appends(request()->query())->links() }}
    </div>

@endsection
