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
use App\Models\GroupCode;
use Session;
use Gate;
use Log;
use Illuminate\Support\Facades\DB;
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

    return view('config.sr-import', compact('company_code', 'ext_id', 'ext_token', 'stores'));
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

  public function productStore(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;
    $company = Company::where('id', $cid)->first();

    $this->authorize('update', $company); // 他の人は見れないように

    $rules = [
      'ext_id'   => ['required', 'AlphaNumeric'],
      'ext_token'  => ['required', 'AlphaNumeric'],
      'pcoderadio'  => ['required', 'boolean'],
      'jancode'  => ['required', 'SmBar'],
    ];
    $this->validate($request, $rules);

    $janCodes = $request->jancode; // Jan取得
    $janStr = str_replace(array("\r\n", "\r", "\n"), "\n", $janCodes); // 改行コードを統一
    $janArr = explode("\n", $janStr); // Janを配列に変換
    $cnt = count($janArr);

    if ($cnt > 100) {
      return redirect('/config/sr-import')->with('danger', '※101件以上のため処理を中断しました');
    }
    // dd($janArr);
    $pcodeRadio = $request->pcoderadio;
    // dd($pcodeRadio);

    $ext_id = $company->ext_id; //'th9685';
    $ext_token = $company->ext_token; //'2a54de73f15ea4f228c70b6f556bd26e';
    $url = 'https://webapi.smaregi.jp/access/';
    $proc_name = 'product_ref';
    $table_name = 'Product';
    // $table_name = 'ProductPrice';
    $gs1 = $company->gs1_company_prefix;
    // substr($string, 0, 3);
    $makerFlag = $company->maker_flag;
    $skip = 0;
    $done = 0;

    foreach ($janArr as $jan) {
      $conditions = [
        [
          'productCode' => $jan
        ],
      ];

      $params = [
        'table_name' => $table_name,
        'conditions' => $conditions
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

      if ($response->clientError()) {
        return redirect('/config/sr-import')->with('danger', '※登録に失敗しました');
      }

      $stream = (string) $response->getBody();

      $contents = json_decode($stream);

      if (empty($contents->result)) {
        // 値が空の場合はスキップ
        $skip = ++$skip;
        // dd($skip);
        continue;
      }
      $result = $contents->result;

      // dd($result[0]->supplierProductNo);
      // dd($contents);
      if (empty($result[0]->supplierProductNo)) {
        // 品番登録がない場合はJANの値を品番に入力
        $productCode = $result[0]->productCode;
        if($results[0]->displayFlag === "0"){
          // 表示しない設定の商品はスキップ
          continue;
        }
      } else {
          // 品番登録がある場合は品番を入力
          $productCode = $result[0]->supplierProductNo;
          // 品番に重複がある場合はJANを入力
          $pCodeCheck = DB::table('items')->where('company_id', $user->company_id)->where('product_code', $productCode)->exists();
          if(!$pCodeCheck){
            $productCode = $result[0]->productCode;
          }
      }

      $janCode = $result[0]->productCode;

      if ($makerFlag === 0) {
        // メーカーじゃない場合はカタログＯＦＦ
        $globalFlag = '0';
      } elseif ($makerFlag === 1) {
        // メーカーでかつ、ＪＡＮが先頭一致する場合はカタログＯＮ
        if (substr($janCode, 0) === $gs1) {
          $globalFlag = '1';
        } else {
          $globalFlag = '0';
        }
      }

      // グループコードがテーブルに存在するかチェックして、booleanで戻す
      $gc = $result[0]->groupCode;
      $group = DB::table('group_codes')->where('company_id', $user->company_id)->where('group_code', $gc)->exists();
      if ($group) {
        //グループコードがDBにある場合
        $gid = GroupCode::where('company_id', $user->company_id)->where('group_code', $gc)->first();
        $gCd = $gid->id;
      } elseif (!$group && isset($gc)) {
        //グループコードがなくて、コードが入力されている場合の処理
        $gCode = new GroupCode;
        $gCode->group_code = $gc;
        $gCode->company_id = $cid;
        $gCode->save();
        // 保存したIDを取得
        $last_insert_id = $gCode->id;
        $gCd = $last_insert_id;
      } else {
        //グループコード未記入の場合の処理
        $gCd = null;
      }
      // dd($cid);
      if ($pcodeRadio === "0") {
        // 既存の値がある場合はスキップ、ない場場合は規登録
        $item = Item::firstOrCreate(
          ['barcode' => $result[0]->productCode, 'company_id' => $company->id],
          [
            'company_id' => $company->id,
            'barcode' => $result[0]->productCode,
            'product_code' => $productCode,
            'product_name' => $result[0]->productName,
            'original_price' => $result[0]->price,
            'description' => $result[0]->description,
            'size' => $result[0]->size,
            'color_name' => $result[0]->color,
            'ext_product_code' => $result[0]->productId,
            'display_flag' => $result[0]->displayFlag,
            'group_code_id' => $gCd,
            'item_status' => '1',
            'global_flag' => $globalFlag
          ]
        );
        $done = ++$done;
      } elseif ($pcodeRadio === "1") {
        // 既存の値がある場合は更新、ない場場合は規登録
        // dd($cid);
        $item = Item::updateOrCreate(
          ['barcode' => $result[0]->productCode, 'company_id' => $company->id],
          [
            'company_id' => $company->id,
            'barcode' => $result[0]->productCode,
            'product_code' => $productCode,
            'product_name' => $result[0]->productName,
            'original_price' => $result[0]->price,
            'description' => $result[0]->description,
            'size' => $result[0]->size,
            'color_name' => $result[0]->color,
            'tag' => $result[0]->tag,
            'ext_product_code' => $result[0]->productId,
            'display_flag' => $result[0]->displayFlag,
            'group_code_id' => $gCd,
            'item_status' => '1',
            'global_flag' => $globalFlag
          ]
        );
        $done = ++$done;
      }

      // 保存したIDを取得
      $last_insert_id = $item->id;
      // Itemテーブルから見つける
      $last_insert_id = Item::find($last_insert_id);
      // ストアテーブルからカンパニーIDで見つける
      $store = Store::where('company_id', $cid)->pluck('id');
      // 中間テーブルに関連づける(完全重複以外は登録される)
      $last_insert_id->store()->syncWithoutDetaching($store);
    }

    return redirect('/config/sr-import')->with('success', '※商品情報を登録しました。成功' . $done . '件 / 失敗' . $skip . '件');
    // return view('config.sr-import', compact('company_code', 'productLists', 'ext_id', 'ext_token', 'stores'));
  }

  public function productAllStore(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;
    $company = Company::where('id', $cid)->first();

    $this->authorize('update', $company); // 他の人は見れないように

    $rules = [
      'ext_id'   => ['required', 'AlphaNumeric'],
      'ext_token'  => ['required', 'AlphaNumeric'],
      'allradio'  => ['required', 'boolean']
    ];
    $this->validate($request, $rules);

    $allRadio = $request->allradio;

    $ext_id = $company->ext_id; //'th9685';
    $ext_token = $company->ext_token; //'2a54de73f15ea4f228c70b6f556bd26e';
    $url = 'https://webapi.smaregi.jp/access/';
    $proc_name = 'product_ref';
    $table_name = 'Product';
    // $table_name = 'ProductPrice';
    $gs1 = $company->gs1_company_prefix;
    // substr($string, 0, 3);
    $makerFlag = $company->maker_flag;
    $done = 0;

    $params = [
      'table_name' => $table_name
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

    //　エラーの場合
    if ($response->clientError()) {
      // dd($contents);
      return redirect('/config/sr-import')->with('danger', '※登録に失敗しました。エラー内容：'. $contents->error_description);
    }
    
    // 全部で何件登録が必要か確認して、ページ数を算出
    $totalCount = $contents->total_count;
    $totalPage = ceil($totalCount / 1000);

    // dd($totalPage);
    // dd($contents);

    // ページ数の分だけ繰り返し処理して商品データを登録していく
    for ($i = 1; $i <= $totalPage; $i++) {
      $params = [
        'page' => $i,
        'table_name' => $table_name
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
      $results = $contents->result;
      // dd($results);
      for ($j = 0; $j <= 999; $j++) {
        if (empty($results[$j])){
          continue;
        }
        // dd($results[$j]);
        // 表示しない設定の商品はスキップ
        // if($results[$j]->displayFlag === "0"){
        //   continue;
        // }

        if (empty($results[$j]->supplierProductNo)) {
          // 品番登録がない場合はJANの値を品番に入力
          $productCode = $results[$j]->productCode;
          if($results[$j]->displayFlag === "0"){
            // 表示しない設定の商品はスキップ
            continue;
          }
        } else {
          // 品番登録がある場合は品番を入力
          $productCode = $results[$j]->supplierProductNo;
          // 品番に重複がある場合はJANを入力
          $pCodeCheck = DB::table('items')->where('company_id', $user->company_id)->where('product_code', $productCode)->exists();
          if($pCodeCheck){
            $productCode = $results[$j]->productCode;
          }
        }
        $janCode = $results[$j]->productCode;
        
        if ($makerFlag === 0) {
          // メーカーじゃない場合はカタログＯＦＦ
          $globalFlag = '0';
        } elseif ($makerFlag === 1) {
          // メーカーでかつ、ＪＡＮが先頭一致する場合はカタログＯＮ
          if (substr($janCode, 0) === $gs1) {
            $globalFlag = '1';
          } else {
            $globalFlag = '0';
          }
        }

        // グループコードがテーブルに存在するかチェックして、booleanで戻す
        $gc = $results[$j]->groupCode;
        $group = DB::table('group_codes')->where('company_id', $user->company_id)->where('group_code', $gc)->exists();
        if ($group) {
          //グループコードがDBにある場合
          $gid = GroupCode::where('company_id', $user->company_id)->where('group_code', $gc)->first();
          $gCd = $gid->id;
        } elseif (!$group && isset($gc)) {
          //グループコードがなくて、コードが入力されている場合の処理
          $gCode = new GroupCode;
          $gCode->group_code = $gc;
          $gCode->company_id = $cid;
          $gCode->save();
          // 保存したIDを取得
          $last_insert_id = $gCode->id;
          $gCd = $last_insert_id;
        } else {
          //グループコード未記入の場合の処理
          $gCd = null;
        }

        // dd($cid);
        if ($allRadio === "0") {
          // 既存の値がある場合はスキップ、ない場場合は規登録
          $item = Item::firstOrCreate(
            ['barcode' => $results[$j]->productCode, 'company_id' => $company->id],
            [
              'company_id' => $company->id,
              'barcode' => $results[$j]->productCode,
              'product_code' => $productCode,
              'product_name' => $results[$j]->productName,
              'original_price' => $results[$j]->price,
              'description' => $results[$j]->description,
              'size' => $results[$j]->size,
              'color_name' => $results[$j]->color,
              'ext_product_code' => $results[$j]->productId,
              'display_flag' => $results[$j]->displayFlag,
              'group_code_id' => $gCd,
              'item_status' => '1',
              'global_flag' => $globalFlag
            ]
          );
          $done = ++$done;
        } elseif ($allRadio === "1") {
          // 既存の値がある場合は更新、ない場場合は規登録
          // dd($cid);
          $item = Item::updateOrCreate(
            ['barcode' => $results[$j]->productCode, 'company_id' => $company->id],
            [
              'company_id' => $company->id,
              'barcode' => $results[$j]->productCode,
              'product_code' => $productCode,
              'product_name' => $results[$j]->productName,
              'original_price' => $results[$j]->price,
              'description' => $results[$j]->description,
              'size' => $results[$j]->size,
              'color_name' => $results[$j]->color,
              'tag' => $results[$j]->tag,
              'ext_product_code' => $results[$j]->productId,
              'display_flag' => $results[$j]->displayFlag,
              'group_code_id' => $gCd,
              'item_status' => '1',
              'global_flag' => $globalFlag
            ]
          );
          $done = ++$done;
        }
        // 保存したIDを取得
        $last_insert_id = $item->id;
        // Itemテーブルから見つける
        $last_insert_id = Item::find($last_insert_id);
        // ストアテーブルからカンパニーIDで見つける
        $store = Store::where('company_id', $cid)->pluck('id');
        // 中間テーブルに関連づける(完全重複以外は登録される)
        $last_insert_id->store()->syncWithoutDetaching($store);
      }
    }
    return redirect('/config/sr-import')->with('success', '※商品情報を登録しました。成功' . $done . '件');
  }

}
