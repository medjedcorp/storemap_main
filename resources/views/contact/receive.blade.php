<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <head>
        <link rel="stylesheet" href="{{ asset('/css/mail.css') }}">
      </head>
    <body>
      お客様からのお問い合わせがありました。<br>
      確認をお願いします。<br>
      <br>
      ■メールアドレス<br>
      {!! $email !!}<br>
      <br>
      ■タイトル<br>
      {!! $title !!}<br>
      <br>
      ■お問い合わせ内容<br>
      {!! nl2br($body) !!}<br>
    </body>
</html>
