<?php

namespace App\Services;

use Illuminate\Http\Request;

final class PrefectureCsvImportService
{
  /**
   * 以下、バリデーションの設定
   */
  public function validationRules()
  {
      return [
          'code'   => 'required|integer',
          'region' => 'required|string',
          'city'   => 'required|string',
          'ward'   => 'nullable|string',
          'latitude'   => 'required|string',
          'longitude'   => 'required|string',
      ];
  }


  public function validationMessages()
  {
      return [
        'code.required' => 'codeを入力してください',
        'code.integer' => 'codeは整数を入力してください',
        'region.required' => 'regionを入力してください',
        'city.required' => 'cityを入力してください',
        'latitude.required' => 'latitudeを入力してください',
        'longitude.required' => 'longitudeを入力してください',
      ];
  }

  public function validationAttributes()
  {
      return [
          'code'        => 'code',
          'region'      => 'region',
          'city'        => 'city',
          'ward'        => 'ward',
          'latitude'    => 'latitude',
          'longitude'   => 'longitude'
      ];
  }

}
