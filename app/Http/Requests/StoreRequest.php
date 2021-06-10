<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; //ルール使うのに必要

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      if ($this->path() == 'stores')
      {
          return true; //許可
      } elseif ($this->path() == 'stores/'.$this->route('store')) {
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
            // 'store_code' => 'required|regex:/^[a-zA-Z0-9]+$/|max:50|unique:stores,store_code,NULL,company_id,company_id,' . $this->input('company_id'), //同一カンパニーID内で同じストアコードがないかチェック
            'store_code' => [
              'required',
              // 正規表現半角英数字ハイフンで構成された文字列
              'regex:/^[a-zA-Z0-9]+$/',
              'max:20',
              // storesテーブルでユニーク制約。ignoreで入力されたstore_codeはバリデーションから除外する
              Rule::unique('stores')->ignore($this->input('id'))->where(function ($query) {
                  // 入力されたcompany_idと同じ値を持つレコードでのみ検証する
                  $query->where('company_id', $this->input('company_id'));
              }),
            ],
            'store_name' => 'required|string|max:85',
            'store_kana' => 'nullable|string|kana|max:85',
            'store_postcode' => 'required|jpzip|max:8',
            'prefecture' => 'required|in:北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県|max:4',
            'store_city' => 'required|string|max:30',
            'store_adnum' => 'required|string|max:50',
            'store_apart' => 'nullable|string|max:100',
            'store_phone_number' => 'required|jptel|max:20',
            'store_fax_number' => 'nullable|jptel|max:20',
            'store_email' => 'nullable|email|max:255',
            'pause_flag' => 'required|boolean',
            'store_info' => 'nullable|string|max:1000',
            'industry_id' => 'required|integer',
            'store_url' => 'nullable|url',
            'flyer_img' => 'nullable|img_name|max:100',
            'floor_guide' => 'nullable|img_name|max:100',
            'store_img1' => 'nullable|img_name|max:100',
            'store_img2' => 'nullable|img_name|max:100',
            'store_img3' => 'nullable|img_name|max:100',
            'store_img4' => 'nullable|img_name|max:100',
            'store_img5' => 'nullable|img_name|max:100',
            'pay_info' => 'nullable|string|max:500',
            'access' => 'nullable|string|max:255',
            'opening_hour' => 'nullable|string|max:255',
            'closed_day' => 'nullable|string|max:255',
            'parking' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'store_code.required' => '店舗コードを入力してください',
            'store_code.unique' => '他の店舗コードと重複しない値を入力してください',
            'store_code.regex' => '半角英数字のみ使用可能です',
            'store_code.max' => '店舗コードは20文字以内で入力してください',
            'store_name.required' => '店舗名を入力してください',
            'store_name.max' => '店舗名は８５文字以内で入力してください',
            'store_kana.kana' => 'ひらがなで入力してください',
            'store_kana.max' => 'よみがなは８５文字以内で入力してください',
            'store_postcode.required' => '郵便番号を入力してください',
            'store_postcode.jpzip' => '郵便番号はハイフンありの8桁以内で入力してください',
            'store_postcode.max' => '郵便番号は８文字以内で入力してください',
            'prefecture.required' => '都道府県名を入力してください',
            'prefecture.in' => '都道府県名に誤りがあります',
            'prefecture.max' => '都道府県名は４文字以内で入力してください',
            'store_city.required' => '市区町村を入力してください',
            'store_city.max' => '市区町村は３０文字以内で入力してください',
            'store_adnum.required' => '町名・番地を入力してください',
            'store_adnum.max' => '町名・番地は５０文字以内で入力してください',
            'store_apart.max' => 'ビル、マンション名は１００文字以内で入力してください',
            'store_phone_number.required' => '電話番号を入力してください',
            'store_phone_number.jptel' => '電話番号は数値とハイフンのみで入力してください',
            'store_phone_number.max' => '電話番号は２０文字以内で入力してください',
            'store_fax_number.jptel' => 'FAX番号は数値とハイフンのみで入力してください',
            'store_fax_number.max' => 'FAX番号は２０文字以内で入力してください',
            'store_email.email' => 'メールアドレスを入力してください',
            'store_email.max' => 'メールアドレスは２５５文字以内で入力してください',
            'pause_flag.required' => '店舗状態を選択してください',
            'store_info.max' => 'お知らせは１０００文字以内で入力してください',
            'industry_id.required' => '業種設定をしてください',
            'store_url.url' => 'URL形式で入力してください',
            'flyer_img.img_name' => 'peg,png,jpg,gif形式でアップロードしてください',
            'flyer_img.max' => 'ファイル名は100文字以内で入力してください',
            'floor_guide.img_name' => 'peg,png,jpg,gif形式でアップロードしてください',
            'floor_guide.max' => 'ファイル名は100文字以内で入力してください',
            'store_img1.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'store_img1.max' => 'ファイル名は100文字以内で入力してください',
            'store_img2.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'store_img2.max' => 'ファイル名は100文字以内で入力してください',
            'store_img3.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'store_img3.max' => 'ファイル名は100文字以内で入力してください',
            'store_img4.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'store_img4.max' => 'ファイル名は100文字以内で入力してください',
            'store_img5.img_name' => 'jpeg,png,jpg,gif形式でアップロードしてください',
            'store_img5.max' => 'ファイル名は100文字以内で入力してください',
            'pay_info.max' => '決済方法は５００文字以内で入力してください',
            'access.max' => 'アクセスは２５５文字以内で入力してください',
            'opening_hour.max' => '営業時間は２５５文字以内で入力してください',
            'closed_day.max' => '定休日は２５５文字以内で入力してください',
            'parking.max' => '駐車場は２５５文字以内で入力してください',
        ];
    }
}
