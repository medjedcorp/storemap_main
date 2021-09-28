<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportSendMail;
use App\Mail\SupportReceiveMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class SupportController extends Controller
{
    public function index()
    {
      $user = Auth::user();
      $cid = $user->company_id;
      $name = $user->name;
      $email = $user->email;
      $c_name = Company::where('id', $cid)->pluck('company_name')->first();
  
      return view('support.index', compact('c_name','name','email','cid'));
    }

    public function confirm(Request $request)
    {
        //バリデーションを実行（結果に問題があれば処理を中断してエラーを返す）
        $messages = [
            'company.required' => '会社名を入力してください',
            'cid.required' => '会社IDを入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'name.required' => 'お名前を入力してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
        ];
        
        $validator = Validator::make($request->all(), [
            'company' => 'required',
            'cid' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'detail'  => 'required'
        ],$messages);

        if ($validator->fails()) {
            return redirect()
                ->route('support.index')
                ->withErrors($validator)
                ->withInput();
        }

        //フォームから受け取ったすべてのinputの値を取得
        $inputs = $request->all();

        //入力内容確認ページのviewに変数を渡して表示
        return view('support.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function send(Request $request)
    {

        $messages = [
            'company.required' => '会社名を入力してください',
            'cid.required' => '会社IDを入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'name.required' => 'お名前を入力してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
        ];
 
        $validator = Validator::make($request->all(), [
            'company' => 'required',
            'cid' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'detail'  => 'required'
        ],$messages);


        if ($validator->fails()) {
            return redirect()
                ->route('support.index')
                ->withErrors($validator)
                ->withInput();
        }

        //フォームから受け取ったactionの値を取得
        $action = $request->input('action');

        //フォームから受け取ったactionを除いたinputの値を取得
        $inputs = $request->except('action');

        //actionの値で分岐
        if ($action !== 'submit') {
            return redirect()
                ->route('support.index')
                ->withInput($inputs);
        } else {
            //入力されたメールアドレスにメールを送信
            Mail::to($inputs['email'])->send(new SupportSendMail($inputs));

            // 入力された内容を本社にも送信
            Mail::to('smsupport@storemap.jp')->send(new SupportReceiveMail($inputs));

            //再送信を防ぐためにトークンを再発行
            $request->session()->regenerateToken();

            //送信完了ページのviewを表示
            return view('support.thanks');
        }
    }
}
