<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use \GuzzleHttp;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Store;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use Session;
use Gate;
use Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SmApiShowController extends Controller
{

    public function show(Request $request)
    {
        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();

        $this->authorize('view', $company); // 他の人は見れないように

        $company_code = $company->company_code;
        $api_flag = $company->api_flag;
        $api_token = $company->api_token;
        // if (isset($company->ext_id)){
        //     $ext_id = $company->ext_id;
        // } else {
        //     $ext_id = null;
        // }
        // if (isset($company->ext_token)){
        //     $ext_token = $company->ext_token;
        // } else {
        //     $ext_token = null;
        // }

        // $stores = Store::where('company_id', $user->company_id)->get();

        return view('config.sm-import', compact('company_code', 'api_flag', 'api_token'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();

        $this->authorize('update', $company); // policy

        $company->api_flag = $request->api_flag;

        $company->save();

        return redirect('/config/sm-import')->with('success', '※API情報を更新しました');
    }

    public function generateApiKey()
    {
        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();

        $this->authorize('update', $company); // policy

        $api_flg = true;

        while ($api_flg) {
          // true でループ開始
          $api_token = Str::random(32);
          // 存在チェック。存在する場合はtrueで、ループ継続
          $api_flg = DB::table('companies')->where('api_token', $api_token)->exists();
          // 存在しない場合はfalse になってループ終了
        }

        $company->api_token = $api_token;
        $company->save();

        return redirect('/config/sm-import')->with('success', '※APIトークンを作成しました');
    }


    public function destroy()
    {
        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();

        $this->authorize('delete', $company); // policy
        Gate::authorize('isSeller'); // gate staffは削除不可

        // $this->authorize('delete', $company);

        $company->api_token = null;
        $company->save();

        return redirect("/config/sm-import")->with('danger', '※APIトークンを削除しました');
    }
}
