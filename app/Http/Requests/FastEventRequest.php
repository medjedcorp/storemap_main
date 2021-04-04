<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FastEventRequest extends FormRequest
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
            'title' => 'required|min:1',
            'start' => 'date_format:H:i:s|before:end',
            'end' => 'date_format:H:i:s|after:start',
            'color' => 'required|in:#007bff,#ffc107,#28a745,#dc3545,#6c757d',
        ];
    }

    public function messages()
    {
      return[
        'title.required' => 'タイトルは必須です',
        'title.min' => 'タイトルは１文字以上で入力してください',
        'start.date_format' => '開始時間は00:00:00の形式で入力してください',
        'start.before' => '開始日は終了日よりも前にしてください',
        'end.date_format' => '終了時間は00:00:00の形式で入力してください',
        'end.after' => '終了日は開始日よりも後にしてください',
        'color.required' => 'カラーを選択してください',
        'color.in' => 'カラーは決められた値の中から選択してください'
      ];
    }
}
