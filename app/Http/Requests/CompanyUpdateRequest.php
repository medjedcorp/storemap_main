<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; //ルール使うのに必要

class CompanyUpdateRequest extends FormRequest
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
      'company_name' => 'required|string|max:85',
      'company_kana' => 'nullable|string|kana|max:85',
      'corporate_number' => [
        'nullable',
        'integer',
        'max:13',
        Rule::unique('companies')->ignore($this->input('company_id')),
      ],
      'president_name' => 'required|string|max:85',
      'company_postcode' => 'required|jpzip|max:8',
      'prefecture' => 'required|in:北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県|max:4',
      'company_city' => 'required|string|max:30',
      'company_adnum' => 'required|string|max:50',
      'company_apart' => 'nullable|string|max:100',
      'company_phone_number' => 'required|jptel|max:20',
      'company_fax_number' => 'nullable|jptel|max:20',
      'company_email' => 'required|email|max:255',
      'manager_name' => 'required|string|max:85',
      'manager_kana' => 'nullable|string|kana|max:85',
      'site_url' => 'nullable|url|max:255',
      'maker_flag' => 'required|boolean',
      'img_flag' => 'required|boolean',
      'gs1_company_prefix' => [
        'nullable',
        'integer',
        'digits_between:7,9',
        Rule::unique('companies')->ignore($this->input('id')),
        // Rule::exists('companies')->where(function ($query) {
        //   $query->where('maker_flag', 1); // メーカーフラグ1の場合は登録可能
        // }),
      ],
      'certificate' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:1024',
    ];
  }

  public function messages()
  {
    return [
      'company_name.required' => '会社名を入力してください',
      'company_name.max' => '会社名は８５文字以内で入力してください',
      'company_kana.kana' => 'ひらがなで入力してください',
      'company_kana.max' => 'かなは８５文字以内で入力してください',
      'president_name.required' => '代表者名を入力してください',
      'president_name.max' => '代表者名は８５文字以内で入力してください',
      'corporate_number.max' => '法人番号は１３文字以内で入力してください',
      'corporate_number.integer' => '法人番号は数値のみで入力してください',
      'corporate_number.unique' => '法人番号が他社と競合しています。問題のある場合はサポートまで連絡してください',
      'company_postcode.required' => '郵便番号を入力してください',
      'company_postcode.jpzip' => '郵便番号はハイフンありの8桁以内で入力してください',
      'company_postcode.max' => '郵便番号は８文字以内で入力してください',
      'prefecture.required' => '都道府県名を入力してください',
      'prefecture.in' => '都道府県名に誤りがあります',
      'prefecture.max' => '都道府県名は４文字以内で入力してください',
      'company_city.required' => '市区町村を入力してください',
      'company_city.max' => '市区町村は３０文字以内で入力してください',
      'company_adnum.required' => '町名・番地を入力してください',
      'company_adnum.max' => '町名・番地は５０文字以内で入力してください',
      'company_apart.max' => 'ビル、マンション名は１００文字以内で入力してください',
      'company_phone_number.required' => '電話番号を入力してください',
      'company_phone_number.jptel' => '電話番号は数値とハイフンのみで入力してください',
      'company_phone_number.max' => '電話番号は２０文字以内で入力してください',
      'company_fax_number.jptel' => 'FAX番号は数値とハイフンのみで入力してください',
      'company_fax_number.max' => 'FAX番号は２０文字以内で入力してください',
      'company_email.required' => '連絡用e-mailは必須です',
      'company_email.max' => '名前は２５５文字以内で入力してください',
      'company_email.email' => '連絡用e-mailの形式で入力してください',
      'manager_name.required' => '管理責任者の氏名を入力してください',
      'manager_name.max' => '管理責任者名は８５文字以内で入力してください',
      'manager_kana.max' => '管理責任者名は８５文字以内で入力してください',
      'manager_kana.kana' => 'ひらがなで入力してください',
      'site_url.max' => 'サイトURLは２５５文字以内で入力してください',
      'maker_flag.required' => 'メーカー設定を選択してください',
      'maker_flag.boolean' => 'メーカー設定に誤りがあります',
      'img_flag.required' => '他社画像利用設定を選択してください',
      'img_flag.boolean' => '他社画像利用設定に誤りがあります',
      'gs1_company_prefix.integer' => 'GS1事業者コードは、JANコードの前7桁、または9桁を入力してください',
      'gs1_company_prefix.digits_between' => 'GS1事業者コードは、JANコードの前7桁、または9桁を入力してください',
      'gs1_company_prefix.unique' => 'GS1事業者コードが他社と競合しています。問題のある場合はサポートまで連絡してください',
      'gs1_company_prefix.exists' => 'メーカーフラグが「その他」のため登録できません',
      'certificate.mimes' => 'jpeg,png,jpg,gif形式でアップロードしてください',
      'certificate.max' => '画像は1Mbyte以内でアップロードしてください',
    ];
  }

  // 追加バリデーション バリデーション前に起動します
  public function withValidator($validator)
  {
    $validator->after(function ($validator) {
      if ($this->input('maker_flag') == 1) {
        // メーカーフラグが1の場合
        // GS1事業者コードの入力を必須とする
        if (!$this->input('gs1_company_prefix')) {
          $validator->errors()->add('gs1_company_prefix', 'メーカー設定をする場合は、GS1事業者コードが必須です');
        }
      }
    });
  }
}
