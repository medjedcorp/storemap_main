<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use \GuzzleHttp;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Store;
use App\Models\Item;
use Session;
use Gate;
use Log;

use Illuminate\Http\Response;

class SmaregiImportController extends Controller
{

  public function show(Request $request)
  {
    $user = Auth::user();
    $company = Company::where('id', $user->company_id)->first();

    $this->authorize('view', $company); // 他の人は見れないように

    $company_code = $company->company_code;

    if (isset($company->ext_id)) {
      $ext_id = $company->ext_id; //'スマレジの契約ID';
     } else {
      $ext_id = null;
    }

    if (isset($company->ext_token)) {
      $ext_token = $company->ext_token; //'スマレジのアクセストークン';
    } else {
      $ext_token = null;
    }

    $stores = Store::where('company_id', $user->company_id)->get();

    // これでデータ取得は可能です。１０００件までしか取得できないので、現在未実装
    if ($request->product === 'true') {
      // $productId = null;
      $productId = '900014229';
      // $productId = '900014229';
      // $productCode = '900014229';
      // $productCode = null; //'4527772150895';
      $ext_id = $company->ext_id; //'th9685';
      $ext_token = $company->ext_token; //'2a54de73f15ea4f228c70b6f556bd26e';
      $url = 'https://webapi.smaregi.jp/access/';
      $proc_name = 'product_ref';
      $table_name = 'Product';
      // $table_name = 'ProductPrice';

      $conditions = [
        [
          'productId' => $productId
        ],
      ];

      $data_obj = (object) $conditions;
      
      $params = [
        'table_name' => $table_name,
        // 'fields' => optional($data_obj)->fields,
        // 'conditions' => optional($data_obj)->conditions,
        // 'order' => optional($data_obj)->order,
        // 'limit' => optional($data_obj)->limit,
        // 'page' => optional($data_obj)->page,
      ];

      $form_params = [
        'proc_name' => $proc_name,
        'params' => json_encode($params)
      ];

      $response = Http::asForm()->withHeaders([
        'X-contract-id' => $ext_id,
        'X-access-token' => $ext_token,
        'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
      ])->post($url, $form_params);

      $stream = (string) $response->getBody();
      $contents = json_decode($stream);
      dd($contents);
      // dd($contents, $response, $ext_id);

      if(empty($contents->result)){
        return redirect('/config/sr-import')->with('danger', '※商品情報の取り込みに失敗しました。');
      } else {
        $productLists = $contents->result;
      }
      
    } else {
      $productLists = null;
    }

    return view('config.sr-import', compact('company_code', 'productLists', 'ext_id', 'ext_token', 'stores'));
  }

  public function store(Request $request)
  {
    $user = Auth::user();
    $company = Company::where('id', $user->company_id)->first();

    $this->authorize('update', $company); // policy
    // validation
    $rules = [
      'ext_id'   => ['nullable', 'AlphaNumeric'],
      'ext_token'  => ['nullable', 'AlphaNumeric']
    ];
    $this->validate($request, $rules);

    $company->ext_id = $request->ext_id;
    $company->ext_token = $request->ext_token;

    $company->save();

    // return redirect('/config/sr-import')->with('success', $company);
    return redirect('/config/sr-import')->with('success', '※スマレジAPI情報を登録しました');
  }

  // public function storesId(Request $request)
  // {
  //   $user = Auth::user();
  //   $company = Company::where('id', $user->company_id)->first();

  //   $this->authorize('update', $company); // policy

  //   $rules = [
  //     'ext_store_code.*'   => ['nullable', 'AlphaNumeric'],
  //   ];
  //   $messages = [
  //     'AlphaNumeric.*' => 'The :attribute は半角英数字とハイフンのみ使用可能です',
  //   ];
  //   $this->validate($request, $rules, $messages);

  //   $inputs = $request->except('_token', '_method'); // '_token','_method'以外の値を取得

  //   for ($i = 0, $num_inputs = count($inputs['ext_store_code']); $i < $num_inputs; $i++) {
  //     $extStore = Store::where('company_id', $user->company_id)->where('id', $inputs['store_id'][$i])->first(); // store_idのi番目の値を取り出す
  //     $extStore->ext_store_code = $inputs['ext_store_code'][$i];
  //     $extStore->save();
  //   }

  //   return redirect('/config/sr-import')->with('success', '※スマレジ店舗IDを更新しました');
  // }

}
