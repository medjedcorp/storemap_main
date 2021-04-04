<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StockCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        // return true;
        if (route('items.stock.edit' , $request->id)){
            return true; //許可
        } elseif(route('items.comment.edit' , $request->id)) {
            return true; //不許可
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
            'stock_amount' => 'array',
            'stock_amount.*' => 'nullable|integer|between:0,99999999',
            'sort_num.*' => 'nullable|integer|between:0,99999999',
            'shelf_number.*' => 'nullable|string|max:10',
            'catch_copy.*' => 'nullable|string|max:140',
        ];
    }

    public function messages()
    {
        return [
            'stock_amount.*.integer' => '在庫数は整数で入力してください',
            'stock_amount.*.between' => '在庫数は0～99999999以下で入力してください',
            'sort_num.*.integer' => '表示優先順位は整数で入力してください',
            'sort_num.*.between' => '表示優先順位は0～99999999以下で入力してください',
            'shelf_number.*.max' => '棚番号は10文字以内で入力してください',
            'catch_copy.*.max' => '商品コメントは140文字以内で入力してください',
        ];
    }

}
