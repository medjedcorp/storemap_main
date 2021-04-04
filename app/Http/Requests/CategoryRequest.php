<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; //ルール使うのに必要

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      if ($this->path() == 'categories')
      {
          return true; //許可
      } elseif ($this->path() == 'categories/'.$this->route('category')) {
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
              'category_name' => 'required|string|max:125',
              'category_code' => [
                'required',
                // 正規表現半角英数字ハイフンで構成された文字列
                'regex:/^[-a-zA-Z0-9]+$/',
                'max:30',
                // 複合ユニークのバリデーション
                // categoriesテーブルでユニーク制約。ignoreで入力されたcategory_codeはバリデーションから除外する
                Rule::unique('categories')->ignore($this->input('id'))->where(function ($query) {
                    // 入力されたcompany_idと同じ値を持つレコードでのみ検証する
                    $query->where('company_id', $this->input('company_id'));
                }),
              ],
              'display_flag' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
          'category_code.required' => 'カテゴリコードを入力してください',
          'category_code.regex' => 'カテゴリコードは半角英数とハイフンのみ使用可能です',
          'category_code.max' => 'カテゴリコードは30文字以内で入力してください',
          'category_code.unique' => 'カテゴリコードが重複しています',
          'category_code.Uqcate' => 'カテゴリコードが重複しています',
          'category_name.required' => 'カテゴリ名を入力してください',
          'category_name.max' => 'カテゴリ名は125文字以内で入力してください',
          'display_flag.required' => '表示設定を選択してください',
          'display_flag.boolean' => '表示設定に他の値が設定されています',
        ];
    }
}
