<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Http;
use Log;
use App\Models\Company;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;

class SmaregiReceiveController extends Controller
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

        $company = Company::where('ext_id', $headerId)->where('ext_token', $headerToken)->first();


        // Log::debug(print_r($input, true));
        // Log::debug(print_r($params, true));
        // Log::debug(print_r($json_count, true));
        // Log::debug(print_r($arr, true));
        // Log::debug(print_r($url, true));
        // Log::debug(print_r($method, true));
        for ($i = 0; $i < $json_count; $i++) {
            $productId = $arr['data']['0']['rows'][$i]['productId'];
            $storeId =  $arr['data']['0']['rows'][$i]['storeId'];
            $stockAmount = $arr['data']['0']['rows'][$i]['stockAmount'];

            $sId = Store::where('company_id', $company->id)->where('ext_store_code', $storeId)->first();
            $iId = Item::where('company_id', $company->id)->where('ext_product_code', $productId)->first();

            if (is_null($iId)) {
                continue;
            }

            $produt = ItemStore::where('store_id', $sId->id)->where('item_id', $iId->id)->first();

            $produt->stock_amount = $stockAmount;
            $produt->save();

            // \Slack::channel('work')->send($produt);
            // Log::debug(print_r($produt, true));
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
        $company = Company::where('ext_id', $headerId)->where('ext_token', $headerToken)->first();

        // table_name取得。処理を振り分け
        $table_name = $arr['data']['0']['table_name'];

        if ($table_name === 'ProductPrice') {
            // 価格の更新
            for ($i = 0; $i < $json_count; $i++) {
                $productId = $arr['data']['0']['rows'][$i]['productId'];
                $storeId =  $arr['data']['0']['rows'][$i]['storeId'];
                $priceDivision =  0;
                $price = $arr['data']['0']['rows'][$i]['price'];
                $startDate =  $arr['data']['0']['rows'][$i]['startDate'];
                $endDate =  $arr['data']['0']['rows'][$i]['endDate'];

                $iId = Item::where('company_id', $company->id)->where('ext_product_code', $productId)->first();
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
                    $sId = Store::where('company_id', $company->id)->where('ext_store_code', $storeId)->first();
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

                $item = Item::where('ext_product_code', $productId)->where('company_id', $company->id)->first();
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
        // アイテムの数だけ回す


        // Log::debug(print_r($headerId, true));
        // Log::debug(print_r($headerToken, true));

        return response(200);
    }
}
