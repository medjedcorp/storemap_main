<?php

namespace App\Services;

use Illuminate\Http\Request;

final class CategoryCsvImportService
{
  /**
   * 以下、バリデーションの設定
   */
  public function validationRules()
  {
      return [
          'category_code'     => 'required|regex:/^[-a-zA-Z0-9]+$/|max:30',
          'category_name'  => 'nullable|string|max:125',
          'display_flag' => 'nullable|boolean',
      ];
  }

  public function validationMessages()
  {
      return [
        'category_code.required' => 'category_codeを入力してください',
        'category_code.regex' => 'category_codeは半角英数とハイフンのみ使用可能です',
        'category_code.max' => 'category_codeは30文字以内で入力してください',
        // 'category_name.nullable' => 'category_nameを入力してください',
        'category_name.max' => 'category_nameは125文字以内で入力してください',
        // 'display_flag.nullable' => 'display_flagを入力してください',
        'display_flag.boolean' => 'display_flagに0(非表示)または１(表示)を入力してください',
      ];
  }

  public function validationAttributes()
  {
      return [
          'category_code'     => 'category_code',
          'category_name'  => 'category_name',
          'display_flag'  => 'display_flag',
      ];
  }

}
