<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <head>
    <link rel="stylesheet" href="{{ asset('/css/mail.css') }}">
  </head>

<body>
  <p>{{$user['company_name']}}<br>
    {{$user['name']}} 様</p>
  <p>この度は、Storemapに企業登録をお申し込みくださいまして、<br>
    誠にありがとうございます。</p>

  <p>入力いただいた情報をもとに登録審査を行なわせていただきます。<br>
    審査の結果につきましては、翌営業日以内にメールにてご案内いたしますので、<br>
    お待ちくださいますようお願いいたします。</p>

    <p>お客様のID：{{$user['id']}}</p>
  <br>
  <p>
    =================================================<br>
    ※このメールは自動送信されていますので、返信はご遠慮ください。<br>
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