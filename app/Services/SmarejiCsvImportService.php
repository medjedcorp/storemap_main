<?php

namespace App\Services;

use Illuminate\Http\Request;

final class SmarejiCsvImportService
{
  /**
   * 以下、バリデーションの設定
   */
  public function validationRules()
  {
      return [
          'product_code'     => 'required|regex:/^[-a-zA-Z0-9]+$/|max:40',
          'ext_product_code'  => 'nullable|regex:/^[-a-zA-Z0-9]+$/|max:40',
      ];
  }

  public function validationMessages()
  {
      return [
        'product_code.required' => 'product_codeを入力してください',
        'product_code.regex' => 'product_codeは半角英数とハイフンのみ使用可能です',
        'product_code.max' => 'product_codeは40桁以内で入力してください',
        'ext_product_code.regex' => 'ext_product_codeは半角英数とハイフンのみ使用可能です',
        'ext_product_code.max' => 'ext_product_codeは40桁以内で入力してください',
      ];
  }

  public function validationAttributes()
  {
      return [
          'product_code'     => 'product_code',
          'ext_product_code'  => 'ext_product_code',
      ];
  }

}
