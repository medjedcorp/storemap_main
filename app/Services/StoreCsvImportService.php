<?php

namespace App\Services;

use Illuminate\Http\Request;

final class StoreCsvImportService
{
    /**
     * 以下、バリデーションの設定
     */
    public function validationRules()
    {
        return [
            'store_code' => 'required|regex:/^[a-zA-Z0-9]+$/|max:20',
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
            'flyer_url' => 'nullable|url',
            'floor_guide' => 'nullable|url',
            'pay_info' => 'nullable|string|max:500',
            'access' => 'nullable|string|max:255',
            'opening_hour' => 'nullable|string|max:255',
            'closed_day' => 'nullable|string|max:255',
            'parking' => 'nullable|string|max:255',
            // 'store_image' => 'nullable|max:100',
            // 'store_image' => ['regex:/^[-_a-zA-Z0-9]+.(png|jpg|jpeg|gif|)+$/'], //配列にしないとパイプ区切りがエラーになる
            'store_img1' => 'nullable|img_name|max:100',
            'store_img2' => 'nullable|img_name|max:100',
            'store_img3' => 'nullable|img_name|max:100',
            'store_img4' => 'nullable|img_name|max:100',
            'store_img5' => 'nullable|img_name|max:100',
        ];
    }

    public function validationMessages()
    {
        return [
            'store_code.required' => '(store_code)店舗コードを入力してください',
            'store_code.regex' => '(store_code)店舗コードは半角英数字のみ使用可能です',
            'store_code.max' => '(store_code)店舗コードは２０文字以内で入力してください',
            'store_name.required' => '(store_name)店舗名を入力してください',
            'store_name.max' => '(store_name)店舗名は８５文字以内で入力してください',
            'store_kana.kana' => '(store_kana)店舗かなはひらがなで入力してください',
            'store_kana.max' => '(store_kana)店舗かなは８５文字以内で入力してください',
            'store_postcode.required' => '(store_postcode)郵便番号を入力してください',
            'store_postcode.jpzip' => '(store_postcode)郵便番号はハイフンありの8桁以内で入力してください',
            'store_postcode.max' => '(store_postcode)郵便番号は８文字以内で入力してください',
            'prefecture.required' => '(prefecture)都道府県名を入力してください',
            'prefecture.in' => '(prefecture)都道府県名に誤りがあります',
            'prefecture.max' => '(prefecture)都道府県名は４文字以内で入力してください',
            'store_city.required' => '(store_city)市区町村を入力してください',
            'store_city.max' => '(store_city)市区町村は３０文字以内で入力してください',
            'store_adnum.required' => '(store_adnum)町名・番地を入力してください',
            'store_adnum.max' => '(store_adnum)町名・番地は５０文字以内で入力してください',
            'store_apart.max' => '(store_apart)ビル、マンション名は１００文字以内で入力してください',
            'store_phone_number.required' => '(store_phone_number)電話番号を入力してください',
            'store_phone_number.jptel' => '(store_phone_number)電話番号は数値とハイフンのみで入力してください',
            'store_phone_number.max' => '(store_phone_number)電話番号は２０文字以内で入力してください',
            'store_fax_number.jptel' => '(store_fax_number)FAX番号は数値とハイフンのみで入力してください',
            'store_fax_number.max' => '(store_fax_number)FAX番号は２０文字以内で入力してください',
            'store_email.email' => '(store_email)メールアドレス形式で入力してください',
            'store_email.max' => '(store_email)メールアドレスは２５５文字以内で入力してください',
            'pause_flag.required' => '(pause_flag)店舗状態は、0:非公開、1:公開のどちらかを入力してください',
            'store_info.max' => '(store_info)お知らせは１０００文字以内で入力してください',
            'industry_id.required' => '(industry_id)業種設定を入力してください',
            'store_url.url' => '(store_url)URL形式で入力してください',
            'flyer_url.url' => '(flyer_url)URL形式で入力してください',
            'floor_guide.url' => '(floor_guide)URL形式で入力してください',
            // 'store_image.max' => 'store_imageは100文字内で入力してください',
            // 'store_image.regex' => 'store_imageは半角英数とハイフン(-)アンダースコア(_)と＋jpeg,png,jpg,gif形式のみ指定可能です',
            'store_img1.img_name' => '(store_img1)jpeg,png,jpg,gif形式で指定してください',
            'store_img1.max' => '(store_img1)ファイル名は100文字以内で入力してください',
            'store_img2.img_name' => '(store_img2)jpeg,png,jpg,gif形式で指定してください',
            'store_img2.max' => '(store_img2)ファイル名は100文字以内で入力してください',
            'store_img3.img_name' => '(store_img3)jpeg,png,jpg,gif形式で指定してください',
            'store_img3.max' => '(store_img3)ファイル名は100文字以内で入力してください',
            'store_img4.img_name' => '(store_img4)jpeg,png,jpg,gif形式で指定してください',
            'store_img4.max' => '(store_img4)ファイル名は100文字以内で入力してください',
            'store_img5.img_name' => '(store_img5)jpeg,png,jpg,gif形式で指定してください',
            'store_img5.max' => '(store_img5)ファイル名は100文字以内で入力してください',
            'pay_info.max' => '(pay_info)決済方法は５００文字以内で入力してください',
            'access.max' => '(access)アクセスは２５５文字以内で入力してください',
            'opening_hour.max' => '(opening_hour)営業時間は２５５文字以内で入力してください',
            'closed_day.max' => '(closed_day)定休日は２５５文字以内で入力してください',
            'parking.max' => '(parking)駐車場は２５５文字以内で入力してください',
        ];
    }

    public function validationAttributes()
    {
        return [
            'store_code'     => 'store_code',
            'store_name'  => 'store_name',
            'store_kana'  => 'store_kana',
            'store_postcode'  => 'store_postcode',
            'prefecture'  => 'prefecture',
            'store_city'  => 'store_city',
            'store_adnum'  => 'store_adnum',
            'store_apart'  => 'store_apart',
            'store_phone_number'  => 'store_phone_number',
            'store_fax_number'  => 'store_fax_number',
            'store_email'  => 'store_email',
            'pause_flag'  => 'pause_flag',
            'store_info'  => 'store_info',
            'industry_id'  => 'industry_id',
            'store_url'  => 'store_url',
            'flyer_url'  => 'flyer_url',
            'floor_guide'  => 'floor_guide',
            'store_img1'  => 'store_img1',
            'store_img2'  => 'store_img2',
            'store_img3'  => 'store_img3',
            'store_img4'  => 'store_img4',
            'store_img5'  => 'store_img5',
            'pay_info'  => 'pay_info',
            'access'  => 'access',
            'opening_hour'  => 'opening_hour',
            'closed_day'  => 'closed_day',
            'parking'  => 'parking',
        ];
    }
}
