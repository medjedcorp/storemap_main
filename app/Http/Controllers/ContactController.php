<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSendMail;
use App\Mail\ContactReceiveMail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function confirm(Request $request)
    {
        //バリデーションを実行（結果に問題があれば処理を中断してエラーを返す）
        $messages = [
            'email.required' => 'メールアドレスを入力してください',
            'name.required' => 'お名前を入力してください',
            'body.required' => 'お問い合わせ内容を入力してください',
        ];
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'body'  => 'required'
        ],$messages);

        if ($validator->fails()) {
            return redirect()
                ->route('contact.index')
                ->withErrors($validator)
                ->withInput();
        }

        //フォームから受け取ったすべてのinputの値を取得
        $inputs = $request->all();

        //入力内容確認ページのviewに変数を渡して表示
        return view('contact.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function send(Request $request)
    {

        $messages = [
            'email.required' => 'メールアドレスを入力してください',
            'name.required' => 'お名前を入力してください',
            'body.required' => 'お問い合わせ内容を入力してください',
        ];
 
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'body'  => 'required'
        ],$messages);


        if ($validator->fails()) {
            return redirect()
                ->route('contact.index')
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
                ->route('contact.index')
                ->withInput($inputs);
        } else {
            //入力されたメールアドレスにメールを送信
            Mail::to($inputs['email'])->send(new ContactSendMail($inputs));

            // 入力された内容を本社にも送信
            Mail::to('contact@storemap.jp')->send(new ContactReceiveMail($inputs));

            //再送信を防ぐためにトークンを再発行
            $request->session()->regenerateToken();

            //送信完了ページのviewを表示
            return view('contact.thanks');
        }
    }
}
