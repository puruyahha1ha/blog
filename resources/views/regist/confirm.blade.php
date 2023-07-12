@extends('layouts.templete')
@section('title', '登録確認画面')
@section('head')
    <script type="text/javascript">
        //送信ボタンを押した際に送信ボタンを無効化する（連打による多数送信回避）
        $(function() {
            $('[type="submit"]').click(function() {
                $(this).prop('disabled', true); //ボタンを無効化する
                $(this).closest('form').submit(); //フォームを送信する
            });
        });
    </script>
@endsection
@section('main')
    <h1>会員情報確認画面</h1>
    <form action="{{ route('complete') }}" method="post">
        @csrf
        {{-- 氏名 --}}
        <div class="name">
            <p>氏名</p>
            <p>{{ $inputs['name_sei'] }}　{{ $inputs['name_mei'] }}</p>
            <input type="hidden" name="name_sei" value="{{ $inputs['name_sei'] }}">
            <input type="hidden" name="name_mei" value="{{ $inputs['name_mei'] }}">
        </div>
        {{-- ニックネーム --}}
        <div class="form_row">
            <p>ニックネーム</p>
            <p>{{ $inputs['nickname'] }}</p>
            <input type="hidden" name="nickname" value="{{ $inputs['nickname'] }}">
        </div>
        {{-- 性別 --}}
        <div class="gender">
            <p>性別</p>
            <p>
                @if ($inputs['gender'] == 1)
                    男性
                @else
                    女性
                @endif
            </p>
            <input type="hidden" name="gender" value="{{ $inputs['gender'] }}">
        </div>
        {{-- パスワード --}}
        <div class="form_row">
            <p>パスワード</p>
            <p>セキュリティのため非表示</p>
            <input type="hidden" name="password_a" value="{{ $inputs['password_a'] }}">
            <input type="hidden" name="password_check" value="{{ $inputs['password_check'] }}">
        </div>
        {{-- メールアドレス --}}
        <div class="form_row">
            <p>メールアドレス</p>
            <p class="emial_color">{{ $inputs['email'] }}</p>
            <input type="hidden" name="email" value="{{ $inputs['email'] }}">
        </div>
        {{-- 送信・戻る --}}
        <div class="button">
            <input type="submit" name="confirm" value="登録完了" class="submit">
            <input type="submit" name="confirm" value="前に戻る" class="submit_re">
        </div>
    </form>

@endsection
