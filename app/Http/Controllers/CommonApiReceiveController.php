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
class CommonApiReceiveController extends Controller
{
    public function stockImport(Request $request)
    {
        // $input = $request->all();
        // 送られてきたデータ取得
        $arr = $request;
        // return response($request);
        // jsonに変換
        // $arr = json_decode($params, true);
        // Log::debug(print_r($params, true));
        // Log::debug(print_r($arr, true));
        // ヘッダーにあるidとtokenを取得(スマレジで設定)
        $headerId = $request->header('X-contract-id');
        $headerToken = $request->header('X-access-token');
        // $headerId = $request->header('id');
        // $headerToken = $request->header('token');
        // Log::debug(print_r($request->header(), true));
        // Log::debug(print_r($headerId, true));
        // Log::debug(print_r($headerToken, true));

        // 何商品分データあるか、rowsをカウント。
        $json_count = count($arr['data']['rows']);
        // $storeId =  $arr['data']['0']['rows'][$i]['productId'];

        // 会社チェック。データない場合は、とりあえずレスポンス200を送信
        // $cCheck = DB::table('companies')->where('ext_id', $headerId)->where('ext_token', $headerToken)->exists();
        if (Company::where('company_code', $headerId)->where('api_token', $headerToken)->exists()) {
            $company = Company::where('company_code', $headerId)->where('api_token', $headerToken)->first();
            $api_flag =  $company->api_flag;
            if ($api_flag === 0) {
                return response(403);
            }
        } else {
            return response(404);
        }

        // Log::debug(print_r($input, true));
        // Log::debug(print_r($params, true));
        // Log::debug(print_r($json_count, true));
        // Log::debug(print_r($arr, true));
        // Log::debug(print_r($url, true));
        // Log::debug(print_r($method, true));
        // $errorLists = array();
        $errorLists = [];

        for ($i = 0; $i < $json_count; $i++) {
            // Log::debug(print_r($i, true));
            $productId = $arr['data']['rows'][$i]['productId'];
            $storeId =  $arr['data']['rows'][$i]['storeId'];
            $stockAmount = $arr['data']['rows'][$i]['stockAmount'];

            // 存在チェック
            // $sCheck = DB::table('stores')->where('company_id', $company->id)->where('ext_store_code', $storeId)->exists();
            // $iCheck = DB::table('items')->where('company_id', $company->id)->where('ext_product_code', $productId)->exists();
            $sCheck = Store::where('company_id', $company->id)->where('store_code', $storeId)->exists();
            $iCheck = Item::where('company_id', $company->id)->where('product_code', $productId)->exists();

            if ($sCheck === true && $iCheck === true) {
                $sId = Store::where('company_id', $company->id)->where('store_code', $storeId)->first();
                $iId = Item::where('company_id', $company->id)->where('product_code', $productId)->first();
            } elseif ($sCheck === false && $iCheck === false) {
                $errorLists[$i] = "[店舗コードと商品コードが見つかりませんでした]  店舗コード：" . $storeId . " / 商品コード：" . $productId;
                 continue;
                // エラーの店舗コードを配列化してまとめる。重複は削除する。ない場合はコンティニューでスキップ。for文終わってからメール送信処理。
            } elseif ($sCheck === false && $iCheck === true) {
                $errorLists[$i] = "[店舗コードが見つかりませんでした]  店舗コード：". $storeId . " / 商品コード：" . $productId . "\n";
                continue;
            } elseif ($sCheck === true && $iCheck === false) {
                $errorLists[$i] = "[商品コードが見つかりませんでした]  店舗コード：". $storeId . " / 商品コード：" . $productId . "\n";
                continue;
            }

            // if (is_null($iId)) {
            //     continue;
            // }

            $produt = ItemStore::where('store_id', $sId->id)->where('item_id', $iId->id)->first();

            $produt->stock_amount = $stockAmount;
            $produt->save();

        }

        // Log::debug(print_r($errorLists, true));

        if (count($errorLists) > 0) {
            $site = "在庫API";
            $to = $company->company_email;
            $company_name = $company->company_name;
            Mail::to($to)->send(new DataWorkerErrorMail($company_name, $errorLists, $site));
            // Log::debug(print_r($errorLists, true));
            // return response($errorLists);
            return response(404);
        }

        // Log::debug(print_r($headerId, true));
        // Log::debug(print_r($headerToken, true));

        return response(200);
    }

    public function itemImport(Request $request)
    {
        $params = $request->input('params');
        // jsonに変換

        $arr = json_decode($params, true);
        // Log::debug(print_r($arr, true));

        // 何商品分データあるか、rowsをカウント。
        $json_count = count($arr['data']['0']['rows']);
        // ヘッダーにあるidとtokenを取得(スマレジで設定)
        $headerId = $request->header('id');
        $headerToken = $request->header('token');
        // 会社セグメント
        $company = Company::where('company_code', $headerId)->where('api_token', $headerToken)->first();

        // table_name取得。処理を振り分け
        $table_name = $arr['data']['0']['table_name'];

        if ($table_name === 'ProductPrice') {
            // 価格の更新
            for ($i = 0; $i < $json_count; $i++) {
                $productId = $arr['data']['0']['rows'][$i]['productId'];
                $storeId = $arr['data']['0']['rows'][$i]['storeId'];
                $priceDivision = 0;
                $price = $arr['data']['0']['rows'][$i]['price'];
                $startDate = $arr['data']['0']['rows'][$i]['startDate'];
                $endDate = $arr['data']['0']['rows'][$i]['endDate'];

                $iId = Item::where('company_id', $company->id)->where('product_code', $productId)->first();
                if (is_null($iId)) {
                    // アイテムが見つからない場合はスキップ
                    continue;
                }

                // Log::debug(print_r($storeId,true));
                if ($storeId === '_ALL_') {
                    // 全店の場合の処理
                    $sId = Store::where('company_id', $company->id)->pluck('id');
                    $sId_count = count($sId);

                    for ($v = 0; $v < $sId_count; $v++) {
                        // 店舗を見つけて、１個ずつ処理
                        $produt = ItemStore::where('store_id', $sId[$v])->where('item_id', $iId->id)->first();
                        $produt->price_type = $priceDivision;
                        $produt->value = $price;
                        $produt->start_date = $startDate;
                        $produt->end_date = $endDate;
                        $produt->save();
                    }
                } else {
                    // 店舗個別の処理
                    $sId = Store::where('company_id', $company->id)->where('store_code', $storeId)->first();
                    $produt = ItemStore::whereIn('store_id', $sId)->where('item_id', $iId->id)->first();
                    $produt->price_type = $priceDivision;
                    $produt->value = $price;
                    $produt->start_date = $startDate;
                    $produt->end_date = $endDate;
                    $produt->save();
                }
            }
        } elseif ($table_name === 'Product') {
            // 商品情報の更新。現状、表示設定と定価のみ変更
            for ($i = 0; $i < $json_count; $i++) {
                $productId = $arr['data']['0']['rows'][$i]['productId'];
                $displayFlag = $arr['data']['0']['rows'][$i]['displayFlag'];
                $price = $arr['data']['0']['rows'][$i]['price'];

                $item = Item::where('product_code', $productId)->where('company_id', $company->id)->first();
                // Log::debug(print_r($item, true));
                if (is_null($item)) {
                    continue;
                }
                // 定価と表示非表示を変更
                $item->original_price = $price;
                $item->display_flag = $displayFlag;
                $item->save();
            }
        }

        // Log::debug(print_r($headerId, true));
        // Log::debug(print_r($headerToken, true));

        return response(200);
    }
}
