@extends('layouts.templete')
@if ($inputs['from'] == 'regist')
    @section('title', '商品カテゴリ登録')
@else
    @section('title', '商品カテゴリ編集')
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
        <p>商品カテゴリ登録</p>
    @else
        <p>商品カテゴリ編集</p>
    @endif
    <a href="/admin/category_list">一覧へ戻る</a>
@endsection
@section('main')
    <form method="POST" action="{{ route('admin.category_list.complete') }}">
        @csrf

        {{-- ID --}}
        <div class="form_row">
            <p>商品大カテゴリID</p>
            @if ($inputs['from'] == 'regist')
                <p>登録後に自動採番</p>
            @else
                <p>{{ $inputs['id'] }}</p>
                <input type="hidden" name="id"
                    value="@if (old('id')) {{ old('id') }}@else{{ $inputs['id'] }} @endif">
            @endif
        </div>

        {{-- 商品大カテゴリ --}}
        <div class="form_row">
            <p>商品大カテゴリ</p>
            <p>{{ $inputs['name'] }}</p>
            <input type="hidden" name="name" value="{{ $inputs['name'] }}">
        </div>


        {{-- 商品小カテゴリ --}}
        <div class="form_row" style="height: auto">
            <p>商品小カテゴリ</p>
            <div class="inputs">

                @for ($i = 1; $i <= 10; $i++)
                    @php
                        $name = "sub_name$i";
                    @endphp
                    {{-- 小カテゴリ --}}
                    <p style="margin-bottom: 10px">{{ $inputs[$name] }}</p>
                    <input type="hidden" name="sub_name{{ $i }}" value="{{ $inputs[$name] }}">
                @endfor

            </div>
        </div>

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
