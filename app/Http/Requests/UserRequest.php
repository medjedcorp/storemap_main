<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'email' => 'required|email|unique:users,email|max:255',
            'role' => 'required|in:staff,seller',
            'password' => 'required|min:8|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.max' => '名前は８５文字以内で入力してください',
            'email.required' => 'e-mailは必須です',
            'email.max' => '名前は２５５文字以内で入力してください',
            'email.email' => 'e-mailの形式で入力してください',
            'email.unique' => '同じe-mailでの登録が既にあります',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは８文字以上で入力してください',
            'password.max' => 'パスワードは２５５文字以下で入力してください',
            'role.required' => '権限を選択してください',
            'role.in' => '権限に誤りがあります',
        ];
    }
}
