<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <head>
    <link rel="stylesheet" href="{{ asset('/css/mail.css') }}">
  </head>

<body>
  <p>{{$company_name}}&nbsp;ご担当者様</p>
  <p>データ送信時にエラーが発生しました。<br>
  エラー内容をご確認ください。</p>
  <p>サイト:&nbsp;{{ $site }}</p>
  <p>エラー内容<br>
  {{ $errorLists }}
  </p>
 
  <p>※このメールに心当たりがない場合は、メールの破棄をお願いいたします。</p>
  <br>
  <p>
    --
    =================================================<br>
    ※本メールへの返信はできません。<br>
    ※お問い合わせは下記窓口へお願いいたします。<br>
    <br>
    【お問合せ窓口】<br>
    ストアマップサポート<br>
    Mail ：smsupport@storemap.jp<br>
    URL ：https://storemap.jp<br>
    <br>
    運営：メジェド合同会社<br>
    =================================================
  </p>
</body>
</html>