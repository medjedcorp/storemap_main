<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <head>
        <link rel="stylesheet" href="{{ asset('/css/mail.css') }}">
      </head>
    <body>
      お問い合わせ内容を受け付けました。<br>
      <br>
      ■メールアドレス<br>
      {!! $email !!}<br>
      <br>
      ■タイトル<br>
      {!! $title !!}<br>
      <br>
      ■お問い合わせ内容<br>
      {!! nl2br($body) !!}<br><br>
      ※こちらのアドレスに返信されても、返信は出来ません。
    </body>
</html>
