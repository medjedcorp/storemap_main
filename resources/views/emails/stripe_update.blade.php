<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <head>
    <link rel="stylesheet" href="{{ asset('/css/mail.css') }}">
  </head>

<body style="-webkit-text-size-adjust:100%; background-color: #efefef; margin:0; padding:0;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%; border:none; margin:2% auto; max-width: 600px;background-color: #ffffff; padding:0 2%;">
    <tr>
      <td style="padding-top:10px;">
        <h3>{{$name}} 様</h3>
        <p>Storemapをご利用いただき誠にありがとうございます。<br>
          お支払い情報を更新致しました。<br>
          ご請求の詳細は下記をご覧ください。</p>
        <p>※このメールに返信されても確認はできません。</p>
        <hr>
      </td>
    </tr>
    <tr>
      <td style="color:#2c2c2c;font-size:18px;line-height:24px;padding-top:30px;"><b>ご請求の概要：</b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="color:#8e8e8e;font-size:14px;line-height:18px;padding-top:20px;">お客様ID</td>
    </tr>
    <tr>
      <td>{{$customer}}</td>
    </tr>
    <tr>
      <td style="color:#8e8e8e;font-size:14px;line-height:18px;padding-top:20px;">会社名</td>
    </tr>
    <tr>
      <td>{{$name}}</td>
    </tr>
    <tr>
      <td style="color:#8e8e8e;font-size:14px;line-height:18px;padding-top:20px;">プラン</td>
    </tr>
    <tr>
      <td>{{$plan_b}}</td>
    </tr>
    <tr>
      <td style="color:#8e8e8e;font-size:14px;line-height:18px;padding-top:20px;">追加店舗数</td>
    </tr>
    <tr>
      <td>{{$quantity}}</td>
    </tr>
    <tr>
      <td style="color:#8e8e8e;font-size:14px;line-height:18px;padding-top:20px;">合計額</td>
    </tr>
    <tr>
      <td>{{$price}} 円（税込）</td>
    </tr>
    <tr>
      <td style="color:#8e8e8e;font-size:14px;line-height:18px;padding-top:20px;">支払い方法</td>
    </tr>
    <tr>
      <td>{{$card_brand}} (末尾番号 {{$card_last}})</td>
    </tr>
    @if(isset($trial))
    <tr>
      <td style="color:#8e8e8e;font-size:14px;line-height:18px;padding-top:20px;">無料期間</td>
    </tr>
    <tr>
      <td>{{$trial}}<BR>※表示内容は、無料期間終了後の請求金額となります。</td>
    </tr>
    @endif
    <tr>
      <td style="padding-top:30px;">
        <hr>
      </td>
    </tr>
    <tr>
      <td style="color:#8e8e8e;font-size:14px;line-height:18px;padding-top:20px;">
        <p>
          =================================================<br>
          ※本メールへの返信はできません。<br>
          ※お問い合わせは下記窓口へお願いいたします。<br>
          <br>
          【お問合せ窓口】<br>
          ストアマップサポート<br>
          Mail ：smsupport@storemap.jp<br>
          Url ：https://storemap.jp<br>
          <br>
          運営 ：メジェド合同会社<br>
          =================================================
        </p>
      </td>
    </tr>
  </table>

</body>

</html>