<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; //ルール使うのに必要

class PriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        // return true;
        if (route('items.price.edit' , $request->id)){
            return true; //許可
        } else {
            return false; //不許可
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price' => 'array',
            'price.*' => 'nullable|integer|between:0,9999999999',
            'value' => 'array',
            'value.*' => 'nullable|integer|between:0,9999999999|lt:price.*',
            'value.*' => 'nullable|integer|between:0,9999999999|lt:price.*',
            'start_date' => 'array',
            'start_date.*' => 'nullable|date_format:Y/m/d H:i',
            // 'start_date.*' => 'nullable|date_format:Y/m/d H:i|before:end_date',
            'end_date' => 'array',
            'end_date.*' => 'nullable|date_format:Y/m/d H:i',
            // 'end_date.*' => 'nullable|date_format:Y/m/d H:i|after:start_date',
            'price_type.*' => 'required|regex:/^[0-2]$/',
        ];
    }

    public function messages()
    {
        return [
            'price.*.integer' => '販売価格は整数で入力してください',
            'price.*.between' => '販売価格は0～9999999999の間で入力してください',
            'value.*.integer' => 'セール価格は整数で入力してください',
            'value.*.between' => 'セール価格は0～9999999999の間で入力してください',
            'value.*.lt'      => 'セール価格は販売価格より低い値を入力してください',
            'start_date.*.date_format' => 'start_dateは2000/01/01 00:00の形式で入力してください',
            'end_date.*.date_format' => 'end_dateは2000/01/01 00:00の形式で入力してください',
            'price_type.*.required' => '価格設定を入力してください',
            'price_type.*.regex' => '価格設定は0(通常価格)、1(最低価格)、2(最高価格)、のいずれかを入力してください',
            // 'start_date.*.before' => 'セール開始日はセール終了日よりも前の日付を入力してください',
            // 'end_date.*.after' => 'セール終了日はセール開始日よりも後の日付を入力してください',
        ];
    }

    // 追加バリデーション バリデーション前に起動します
    public function withValidator($validator) {
      $validator->after(function ($validator) {
        $s = count($this->input('store_id'));
        for( $i=0; $i<$s; $i++){
          $sdate = $this->input('start_date')[$i];
          $edate = $this->input('end_date')[$i];
            if(isset($sdate) and isset($edate)) {
              if( $sdate > $edate ){
              $validator->errors()->add('start_date', 'セール開始日はセール終了日よりも前の日付を入力してください');
              $validator->errors()->add('end_date', 'セール終了日はセール開始日よりも後の日付を入力してください');
                }
              }
            }
        });
      }

}
