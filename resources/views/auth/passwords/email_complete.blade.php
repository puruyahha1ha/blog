@extends('layouts.templete')
@section('title', 'メール送信完了画面')
@section('main')
    <p>
        パスワード再設定の案内メールを送信しました。<br>
        （まだパスワード再設定は完了しておりません）<br>
        届きましたメールに記載されている<br>
        『パスワード再設定URL』をクリックし、<br>
        パスワードの再設定を完了させてください。
    </p>

    <div class="button">
        <a href="/" class="submit_re">トップに戻る</a>
    </div>

@endsection
