<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; //ルール使うのに必要
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      if ($this->path() == 'users/'.$this->route('user'))
      {
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
            'name' => 'required|string|max:85',
            'role' => 'required|in:staff,seller',
            'store_id' => 'array',
            'store_id.*' => [
              'nullable',
              'integer',
              Rule::exists('stores','id')->where(function ($query) {
                $query->where('company_id', $this->input('company_id'));
                }),
              ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.max' => '名前は８５文字以内で入力してください',
            'role.required' => '権限を選択してください',
            'role.in' => '権限に誤りがあります',
            'store_id.*.integer' => '担当店舗設定に誤りがあります',
            'store_id.*.exists' => '担当店舗設定の値に誤りがあります',
        ];
    }
}
