<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Http;
use Log;
use App\Models\Company;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\DataWorkerErrorMail;

// 汎用受信API
class SmApiReceiveController extends Controller
{
    public function stockImport(Request $request)
    {
        // $input = $request->all();
        // 送られてきたデータ取得
        $params = $request->input('params');
        // jsonに変換
        $arr = json_decode($params, true);
        // 何商品分データあるか、rowsをカウント。
        $json_count = count($arr['data']['0']['rows']);
        // ヘッダーにあるidとtokenを取得(スマレジで設定)
        $headerId = $request->header('id');
        $headerToken = $request->header('token');
        // $storeId =  $arr['data']['0']['rows'][$i]['productId'];

        // 会社チェック。データない場合は、とりあえずレスポンス200を送信
        // $cCheck = DB::table('companies')->where('ext_id', $headerId)->where('ext_token', $headerToken)->exists();
        if(Company::where('ext_id', $headerId)->where('ext_token', $headerToken)->exists()){
            $company = Company::where('ext_id', $headerId)->where('ext_token', $headerToken)->first();
        } else {
            return response(200);
        }
        
        // Log::debug(print_r($input, true));
        // Log::debug(print_r($params, true));
        // Log::debug(print_r($json_count, true));
        // Log::debug(print_r($arr, true));
        // Log::debug(print_r($url, true));
        // Log::debug(print_r($method, true));
        $errorLists = [];

        for ($i = 0; $i < $json_count; $i++) {
            $productId = $arr['data']['0']['rows'][$i]['productId'];
            $storeId =  $arr['data']['0']['rows'][$i]['storeId'];
            $stockAmount = $arr['data']['0']['rows'][$i]['stockAmount'];

            // 存在チェック
            // $sCheck = DB::table('stores')->where('company_id', $company->id)->where('ext_store_code', $storeId)->exists();
            // $iCheck = DB::table('items')->where('company_id', $company->id)->where('ext_product_code', $productId)->exists();
            $sCheck = Store::where('company_id', $company->id)->where('ext_store_code', $storeId)->exists();
            $iCheck = Item::where('company_id', $company->id)->where('ext_product_code', $productId)->exists();

            if ( $sCheck === true && $iCheck === true ) {
                $sId = Store::where('company_id', $company->id)->where('ext_store_code', $storeId)->first();
                $iId = Item::where('company_id', $company->id)->where('ext_product_code', $productId)->first();
            } elseif( $sCheck === false && $iCheck === false ) {
                $errorLists[] = $storeId .":". $productId. " (店舗コードと商品コードが見つかりませんでした。\n)";
                // $errorSid[] = $storeId;
                // continue;
                // エラーの店舗コードを配列化してまとめる。重複は削除する。ない場合はコンティニューでスキップ。for文終わってからメール送信処理。
            } elseif( $sCheck === false && $iCheck === true ) {
                $errorLists[] = $storeId .":". $productId. " (店舗コードが見つかりませんでした。\n)";
            } elseif( $sCheck === true && $iCheck === false ) {
                $errorLists[] = $storeId .":". $productId. " (商品コードが見つかりませんでした。\n)";
            }

            // if (is_null($iId)) {
            //     continue;
            // }

            $produt = ItemStore::where('store_id', $sId->id)->where('item_id', $iId->id)->first();

            $produt->stock_amount = $stockAmount;
            $produt->save();

            // \Slack::channel('work')->send($produt);
            // Log::debug(print_r($produt, true));
        }
        
        if (count($errorLists) > 0) {
            $site = "API";
            $to = $company->company_email;
            $company_name = $company->company_name;
            Mail::to($to)->send(new DataWorkerErrorMail($company_name, $errorLists, $site));
        }

        // Log::debug(print_r($headerId, true));
        // Log::debug(print_r($headerToken, true));

        return response(200);
    }

}
