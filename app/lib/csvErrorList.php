<?php

use Illuminate\Support\Facades\Storage;

// 自作関数 composer.jsonで読み込み
function csvErrorList($error_list, $fname)
{

  Storage::disk('public')->put($fname, "");

  // エラーログをテキストで出力
  $err_num = 1;
  foreach ($error_list as $key => $val) {
    $key++;
    foreach ($val as $msg) {
      $err_num++;
      $txt_list = 'データ' . $key . '行目：' . $msg;
      Storage::disk('public')->append($fname, $txt_list);
    }
    if($err_num > 1000){
      $txt_list = 'エラー件数が1000件を超えました。csvの内容を再度確認してください';
      Storage::disk('public')->append($fname, $txt_list);
    break;
    }
  }

}
