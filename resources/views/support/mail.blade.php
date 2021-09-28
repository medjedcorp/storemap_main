<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <head>
        <link rel="stylesheet" href="{{ asset('/css/mail.css') }}">
      </head>
    <body>
      お問い合わせを受け付けました。<br>
      <br>
      ■会社名<br>
      {!! $company !!}<br>
      <br>
      ■メールアドレス<br>
      {!! $email !!}<br>
      <br>
      ■お名前<br>
      {!! $name !!}<br>
      <br>
      ■お問い合わせ内容<br>
      {!! nl2br($detail) !!}<br><br>
      ※こちらのアドレスに返信されても、返信は出来ません。
    </body>
</html>
