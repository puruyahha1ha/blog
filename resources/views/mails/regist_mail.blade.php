お名前：{{ $content['name_sei'] }}　{{ $content['name_mei'] }}<br>
ニックネーム{{ $content['nickname'] }}<br>
性別：@if ($content['gender'] == 1)
    男性
@else
    女性
@endif
<br>
パスワード：セキュリティのため非表示<br>
メールアドレス：{{ $content['email'] }}
