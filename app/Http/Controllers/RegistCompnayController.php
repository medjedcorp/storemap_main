<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Events\UserRegistered;

class RegistCompnayController extends Controller
{
    use RegistersUsers;

    public function index()
    {
        return view('regicom.index');
    }

    public function confirm(Request $request)
    {
        // dd($request);
        //バリデーションを実行（結果に問題があれば処理を中断してエラーを返す）
        $messages = [
            'company_name.required' => '会社名を入力してください',
            'company_name.max' => '会社名は８５文字以内で入力してください',
            'company_kana.required' => '会社名をひらがなで入力してください',
            'company_kana.kana' => 'ひらがなで入力してください',
            'company_kana.max' => 'かなは８５文字以内で入力してください',
            'corporate_number.max' => '法人番号は１３文字以内で入力してください',
            'corporate_number.integer' => '法人番号は数値のみで入力してください',
            'corporate_number.unique' => '法人番号が重複しています。問題のある場合はサポートまでご連絡ください。',
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
            'company_email.unique' => '同じe-mailでの登録が既にあります',
            'password.required' => 'パスワードは必須です',
            'password.min' => 'パスワードは８文字以上で入力してください',
            'password.max' => 'パスワードは２５５文字以内で入力してください',
            'manager_name.required' => '管理責任者の氏名を入力してください',
            'manager_name.max' => '管理責任者名は８５文字以内で入力してください',
            'manager_kana.required' => '管理責任者をひらがなで入力してください',
            'manager_kana.max' => '管理責任者名は８５文字以内で入力してください',
            'manager_kana.kana' => 'ひらがなで入力してください',
            'site_url.max' => 'サイトURLは２５５文字以内で入力してください',
            'p_policy.accepted' => 'ご同意できない場合は登録できません',
        ];

        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:85',
            'company_kana' => 'required|string|kana|max:85',
            'corporate_number' => 'nullable|unique:companies,corporate_number|integer|max:9999999999999',
            'president_name' => 'required|string|max:85',
            'company_postcode' => 'required|jpzip|max:8',
            'prefecture' => 'required|in:北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,富山県,石川県,福井県,山梨県,長野県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県|max:4',
            'company_city' => 'required|string|max:30',
            'company_adnum' => 'required|string|max:50',
            'company_apart' => 'nullable|string|max:100',
            'manager_name' => 'required|string|max:85',
            'manager_kana' => 'required|string|kana|max:85',
            'company_email' => 'required|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
            'company_phone_number' => 'required|jptel|max:20',
            'company_fax_number' => 'nullable|jptel|max:20',
            'site_url' => 'nullable|url|max:255',
            'p_policy' => 'accepted',
        ], $messages);

        if ($validator->fails()) {
            return redirect()
                ->route('regicom.index')
                ->withErrors($validator)
                ->withInput();
        }


        // 受け取った値をDBに登録
        $company = new Company;
        $company->company_name = $request->company_name;
        $company->company_kana = $request->company_kana;
        $company->company_postcode = $request->company_postcode;
        $company->prefecture = $request->prefecture;
        $company->company_city = $request->company_city;
        $company->company_adnum = $request->company_adnum;
        $company->company_apart = $request->company_apart;
        $company->company_phone_number = $request->company_phone_number;
        $company->company_fax_number = $request->company_fax_number;
        $company->company_email = $request->company_email;
        $company->manager_name = $request->manager_name;
        $company->manager_kana = $request->manager_kana;
        $company->site_url = $request->site_url;
        $company->president_name = $request->president_name;
        $company->corporate_number = $request->corporate_number;
        $company->save();

        $last_insert_id = $company->id;
        // $last_id = Company::find($last_insert_id);

        $user = new User;
        $user->name = $request->manager_name;
        $user->email = $request->company_email;
        // パスワードハッシュ化
        $user->password = \Hash::make($request->password);
        // $user->password = \Hash::make($request['password']);
        $user->role = 'new'; // roleにnewを付与
        $user->company_id = $last_insert_id;
        $user->save();

        $user->company_name = $request->company_name;  
        // イベント発生。メール送信
        event(new UserRegistered($user));

        \Auth::logout();

        //フォームから受け取ったすべてのinputの値を取得
        $inputs = $request->all();
        // パスワードは除外
        unset($inputs['password']);

        \Slack::channel('register')->send('あっ、「'.$user->company_name.'(comapny_id:'.$last_insert_id.')」から企業登録申請があったよ！');
        //入力内容確認ページのviewに変数を渡して表示
        return view('regicom.thanks', [
            'inputs' => $inputs,
        ]);

    }

}
