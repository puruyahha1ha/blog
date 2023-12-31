@extends('layouts.templete')
@section('title', '商品レビュー管理')
@section('header_class', 'login_header')

@section('header')
    <p>商品レビュー管理</p>
    <a href="/">トップに戻る</a>
@endsection
@section('main')
    <form action="" method="post">
        @csrf
        {{-- 商品レビュー一覧 --}}
        <div class="list">
            @foreach ($reviews as $val)
                <div class="list_row">
                    {{-- 写真 --}}
                    @for ($i = 1; $i <= 4; $i++)
                        @php
                            $colum_name = "image_$i";
                        @endphp
                        @if (is_null($val->$colum_name))
                            @if ($colum_name == 'image_4')
                                <div class="empty" style="width: 200px; height: 200px">no image</div>
                            @endif
                            @continue
                        @else
                            <img src="{{ asset($val->$colum_name) }}" style="width: 200px; height: 200px">
                        @break
                    @endif
                @endfor

                {{-- 商品情報 --}}
                <div class="information" style="width: auto">
                    <p>{{ $val->main_name }}>{{ $val->sub_name }}</p>
                    <span style="color: blue">{{ $val->name }}</span>
                    @foreach (Config('master.stars') as $key => $star)
                        @if ($key == $val->evaluation)
                            <span>{{ $star }}　{{ $key }}</span>
                        @endif
                    @endforeach
                    <span>@if (mb_strlen($val->comment) > 16)
                        {{ mb_substr($val->comment, 0, 16) }}...
                    @else
                        {{ $val->comment }}
                    @endif</span>

                    {{-- レビュー編集・削除 --}}
                    <div class="buttons">
                        <div class="detail">
                            <a href="{{ route('mypage.control.update', ['id' => $val->id, 'product_id' => $val->product_id]) }}"
                                style="width: 150px; margin-right: 20px">レビュー編集</a>
                        </div>
                        <div class="detail">
                            <a href="{{ route('mypage.control.delete', ['id' => $val->id, 'product_id' => $val->product_id]) }}"
                                style="width: 150px">レビュー削除</a>
                        </div>
                    </div>

                </div>

            </div>
        @endforeach

        {{-- ペジネーション --}}
        <div class="links">
            {{ $reviews->links() }}
        </div>

    </div>

</form>

<div class="detail_button_re">
    <a href="{{ route('mypage') }}">マイページに戻る</a>
</div>

@endsection
