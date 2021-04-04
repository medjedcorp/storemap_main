<?php

namespace App\Services;

use Illuminate\Http\Request;

final class SmCategoryCsvImportService
{
  /**
   * 以下、バリデーションの設定
   */
  public function validationRules()
  {
      return [
          'id'   => 'required|integer',
          'parent_id'   => 'nullable|integer',
          'smcategory_name'   => 'required|string|max:100',


          // 'first_layer'   => 'required|string|max:100',
          // 'second_layer'  => 'required|string|max:100',
          // 'third_layer'   => 'nullable|string|max:100',
          // 'fourth_layer'  => 'nullable|string|max:100',
          // 'fifth_layer'   => 'nullable|string|max:100',
          // 'sixth_layer'   => 'nullable|string|max:100',
      ];
  }


  public function validationMessages()
  {
      return [
        'id.required' => 'idを入力してください',
        'id.integer' => 'idは整数を入力してください',
        'parent_id.integer' => 'parent_idは整数を入力してください',
        'smcategory_name.required' => 'smcategory_nameを入力してください',
        'smcategory_name.max' => 'smcategory_nameは100文字以内で入力してください',
        // 'first_layer.required' => 'first_layerを入力してください',
        // 'first_layer.max' => 'first_layerは100文字以内で入力してください',
        // 'second_layer.required' => 'second_layerを入力してください',
        // 'second_layer.max' => 'second_layerは100文字以内で入力してください',
        // 'third_layer.max' => 'third_layerは100文字以内で入力してください',
        // 'fourth_layer.max' => 'fourth_layerは100文字以内で入力してください',
        // 'fifth_layer.max' => 'fifth_layerは100文字以内で入力してください',
        // 'sixth_layer.max' => 'sixth_layerは100文字以内で入力してください',
      ];
  }

  public function validationAttributes()
  {
      return [
          'id'     => 'id',
          'parent_id'     => 'parent_id',
          'smcategory_name'     => 'smcategory_name',
          // 'first_layer'     => 'first_layer',
          // 'second_layer'  => 'second_layer',
          // 'third_layer'  => 'third_layer',
          // 'fourth_layer'  => 'fourth_layer',
          // 'fifth_layer'  => 'fifth_layer',
          // 'sixth_layer'  => 'sixth_layer',
      ];
  }

}
