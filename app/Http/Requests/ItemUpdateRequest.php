<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule; //ルール使うのに必要

class ItemUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      if ($this->path() == 'items')
      {
          return true; //許可
      } elseif ($this->path() == 'items/'.$this->route('item')) {
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
            // https://teratail.com/questions/99712参照
        return [
            // 'company_id' => 'required',
            'barcode' => [
              'nullable',
              'string',
              // 正規表現半角英数字ハイフンで構成された文字列
              'regex:/^[a-zA-Z0-9]+$/',
              'max:20',
              Rule::unique('items')->ignore($this->input('id'))->where(function ($query) {
                  // 入力されたcompany_idと同じ値を持つレコードでのみ検証する
                  $query->where('company_id', $this->input('company_id'));
              }),
            ],
            'product_code' => [
              'required',
              'string',
              // 正規表現半角英数字ハイフンで構成された文字列
              'regex:/^[-a-zA-Z0-9]+$/',
              'max:40',
              Rule::unique('items')->ignore($this->input('id'))->where(function ($query) {
                  // 入力されたcompany_idと同じ値を持つレコードでのみ検証する
                  $query->where('company_id', $this->input('company_id'));
              }),
            ],
            'product_name' => 'required|string|max:255',
            'brand_name' => 'nullable|string|max:100',
            'original_price' => 'nullable|integer|between:0,9999999999',
            'description' => 'nullable|string|max:10000',
            'color' => 'nullable|in:NULL,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15',
            'tag' => 'nullable|string|max:100',
            'group_code_id' => 'nullable|string',
            'display_flag' => 'required|boolean',
            'global_flag' => 'required|boolean',
            'item_status' => 'required|boolean',
            'category_id' => 'nullable',
            'size' => 'nullable|string|max:10000',
            'size_name' => 'nullable|string|max:10',
            'color_name' => 'nullable|string|max:30',
            'storemap_category_id' => 'nullable|array',
            'item_img1' => 'nullable|img_name|max:100',
            'item_img2' => 'nullable|img_name|max:100',
            'item_img3' => 'nullable|img_name|max:100',
            'item_img4' => 'nullable|img_name|max:100',
            'item_img5' => 'nullable|img_name|max:100',
            'item_img6' => 'nullable|img_name|max:100',
            'item_img7' => 'nullable|img_name|max:100',
            'item_img8' => 'nullable|img_name|max:100',
            'item_img9' => 'nullable|img_name|max:100',
            'item_img10' => 'nullable|img_name|max:100',
        ];
    }

    public function messages()
    {
        return [
            // 'company_id.required' => '最初に会社情報を登録してください',
            'barcode.string' => '英数字で入力してください',
            'barcode.unique' => '他の商品と重複しない値を入力してください',
            'barcode.max' => 'バーコードは20桁以内で入力してください',
            'product_code.required' => '商品コードを入力してください',
            'product_code.regex' => '商品コードは半角英数とハイフンのみ使用可能です',
            'product_code.unique' => '他の商品と重複しない値を入力してください',
            'product_code.max' => '商品コードは40桁以内で入力してください',
            'product_name.required' => '商品を入力してください',
            'product_name.max' => '商品は255文字内で入力してください',
            'brand_name.max' => 'ブランド名は100文字内で入力してください',
            'size_name.max' => 'サイズ名は10文字内で入力してください',
            'color_name.max' => 'カラー名は30文字内で入力してください',
            'original_price.integer' => '価格は整数で入力してください',
            'original_price.between' => '価格は0から9999999999の間で入力してください',
            'description.max' => '商品説明は10000文字内で入力してください',
            'size.max' => 'サイズ詳細は10000文字内で入力してください',
            'color.in' => 'カラーは決めれた値の中から選択してください',
            'tag.max' => 'タグは100文字内で入力してください',
            'display_flag.required' => '表示設定を選択してください',
            'display_flag.boolean' => '0(非公開)または1(公開)を入力してください',
            'global_flag.required' => 'カタログ設定を選択してください',
            'global_flag.boolean' => 'カタログ設定を選択してください',
            'item_status.required' => '商品状態を選択してください',
            'item_status.boolean' => '0(中古)または1(新品)を入力してください',
            // 'storemap_category_id.required' => 'ストアマップカテゴリを選択してください',
            'storemap_category_id.array' => 'ストアマップカテゴリが配列になってません',
            'item_img1.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img1.max' => 'ファイル名は100文字以内で入力してください',
            'item_img2.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img2.max' => 'ファイル名は100文字以内で入力してください',
            'item_img3.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img3.max' => 'ファイル名は100文字以内で入力してください',
            'item_img4.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img4.max' => 'ファイル名は100文字以内で入力してください',
            'item_img5.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img5.max' => 'ファイル名は100文字以内で入力してください',
            'item_img6.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img6.max' => 'ファイル名は100文字以内で入力してください',
            'item_img7.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img7.max' => 'ファイル名は100文字以内で入力してください',
            'item_img8.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img8.max' => 'ファイル名は100文字以内で入力してください',
            'item_img9.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img9.max' => 'ファイル名は100文字以内で入力してください',
            'item_img10.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'item_img10.max' => 'ファイル名は100文字以内で入力してください',
        ];
    }

    // 追加バリデーション バリデーション前に起動します
    public function withValidator($validator) {
      $validator->after(function ($validator) {
        $user = Auth::user();
        $company = DB::table('companies')->where('id', $user->company_id)->first();

        if( $this->input('global_flag') == 1){
          // カンパニーのGS1事業者コードを取得
          $bar_start = $company->gs1_company_prefix;
          // GS1事業者コードと入力されたJANの最初の値が一致するかバリデーション。エラーの場合はエラー表示
          if(!Str::startsWith($this->input('barcode'),$bar_start)) {
            $validator->errors()->add('barcode', 'グローバル商品に登録する場合は、GS1事業者コード('. $bar_start .')から始まる値で登録してください');
          }
        }
      });
    }
}
