@extends('layouts.templete')
@section('title', '管理画面メインメニュー')
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
    <p>管理画面メインメニュー</p>
    <div style="display: flex">
        <p style="margin-right: 20px">ようこそ{{ auth('admin')->user()->name }}様</p>
        <a class="dropdown-item" href="{{ route('admin.logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            ログアウト
        </a>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
@endsection
@section('main')
    <div style="width: 100%; height: 800px"></div>
@endsection
