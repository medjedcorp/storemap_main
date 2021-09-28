<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <head>
        <link rel="stylesheet" href="{{ asset('/css/mail.css') }}">
      </head>
    <body>
      ご契約中のお客様からお問い合わせがありました。<br>
      確認をお願いします。<br>
      <br>
      ■会社名<br>
      {!! $company !!}<br>
      <br>
      ■会社ID<br>
      {!! $cid !!}<br>
      <br>
      ■メールアドレス<br>
      {!! $email !!}<br>
      <br>
      ■お名前<br>
      {!! $name !!}<br>
      <br>
      ■お問い合わせ内容<br>
      {!! nl2br($detail) !!}<br>
    </body>
</html>
