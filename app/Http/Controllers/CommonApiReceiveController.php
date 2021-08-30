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

        // return response($arr);
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
        if (!isset($arr['data']['rows'])) {
            return response()->json(['message' => '400 data not found'], 400);
        } else {
            $json_count = count($arr['data']['rows']);
        }
        // $storeId =  $arr['data']['0']['rows'][$i]['productId'];

        // 会社チェック。データない場合は、とりあえずレスポンス200を送信
        // $cCheck = DB::table('companies')->where('ext_id', $headerId)->where('ext_token', $headerToken)->exists();
        if (Company::where('company_code', $headerId)->where('api_token', $headerToken)->exists()) {
            $company = Company::where('company_code', $headerId)->where('api_token', $headerToken)->first();
            $api_flag =  $company->api_flag;
            if ($api_flag === 0) {
                return response()->json(['message' => '403 Access denied'], 403);
            }
        } else {
            return response()->json(['message' => '400 Company not found'], 400);
        }

        // table_nameが存在するかチェック
        if (!isset($arr['data']['table_name'])) {
            return response()->json(['message' => '400 table_name not found'], 400);
        } else {
            $tableName = $arr['data']['table_name'];
        }

        // table_nameが違う場合エラーを返す
        if (!($tableName === 'Stock')) {
            return response()->json(['message' => '400 Incorrect specification of table_name'], 400);
        }
        // Log::debug(print_r($input, true));
        // Log::debug(print_r($params, true));
        // Log::debug(print_r($json_count, true));
        // Log::debug(print_r($arr, true));
        // Log::debug(print_r($url, true));
        // Log::debug(print_r($method, true));
        $errorLists = [];

        // データがない場合エラーを返す
        if (!isset($arr['data']['rows'][0]['productId'])) {
            return response()->json(['message' => '400 productId not found'], 400);
        } elseif (!isset($arr['data']['rows'][0]['storeId'])) {
            return response()->json(['message' => '400 storeId not found'], 400);
        } elseif (!isset($arr['data']['rows'][0]['stockAmount'])) {
            return response()->json(['message' => '400 stockAmount not found'], 400);
        }

        for ($i = 0; $i < $json_count; $i++) {
            // Log::debug(print_r($i, true));
            $productId = $arr['data']['rows'][$i]['productId'];
            $storeId =  $arr['data']['rows'][$i]['storeId'];
            $stockAmount = $arr['data']['rows'][$i]['stockAmount'];

            // 存在チェック
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
                $errorLists[$i] = "[店舗コードが見つかりませんでした]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                continue;
            } elseif ($sCheck === true && $iCheck === false) {
                $errorLists[$i] = "[商品コードが見つかりませんでした]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                continue;
            }

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
            return response(400);
        }

        // Log::debug(print_r($headerId, true));
        // Log::debug(print_r($headerToken, true));

        return response(200);
    }

    public function itemImport(Request $request)
    {
        // 送られてきたデータ取得
        $arr = $request;

        // ヘッダーにあるidとtokenを取得(スマレジで設定)
        $headerId = $request->header('X-contract-id');
        $headerToken = $request->header('X-access-token');

        // 何商品分データあるか、rowsをカウント。
        if (!isset($arr['data']['rows'])) {
            return response()->json(['message' => '400 data not found'], 400);
        } else {
            $json_count = count($arr['data']['rows']);
        }
        // $storeId =  $arr['data']['0']['rows'][$i]['productId'];

        // 会社チェック。データない場合は、とりあえずレスポンス200を送信
        // $cCheck = DB::table('companies')->where('ext_id', $headerId)->where('ext_token', $headerToken)->exists();
        if (Company::where('company_code', $headerId)->where('api_token', $headerToken)->exists()) {
            $company = Company::where('company_code', $headerId)->where('api_token', $headerToken)->first();
            $api_flag =  $company->api_flag;
            if ($api_flag === 0) {
                return response()->json(['message' => '403 Access denied'], 403);
            }
        } else {
            return response()->json(['message' => '400 Company not found'], 400);
        }

        // table_nameが存在するかチェック
        if (!isset($arr['data']['table_name'])) {
            return response()->json(['message' => '400 table_name not found'], 400);
        } else {
            $tableName = $arr['data']['table_name'];
        }

        // table_nameが違う場合エラーを返す
        if (!($tableName === 'Item')) {
            return response()->json(['message' => '400 Incorrect specification of table_name'], 400);
        }

        $errorLists = [];

        // データがない場合エラーを返す
        if (!isset($arr['data']['rows'][0]['productId'])) {
            return response()->json(['message' => '400 productId not found'], 400);
        } elseif (!isset($arr['data']['rows'][0]['storeId'])) {
            return response()->json(['message' => '400 storeId not found'], 400);
        }
        //  elseif (!isset($arr['data']['rows'][0]['price'])) {
        //     return response()->json(['message' => '400 price not found'], 400);
        // }

        for ($i = 0; $i < $json_count; $i++) {
            // Log::debug(print_r($i, true));

            $productId = $arr['data']['rows'][$i]['productId'];
            $storeId =  $arr['data']['rows'][$i]['storeId'];


            // 存在チェック
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
                $errorLists[$i] = "[店舗コードが見つかりませんでした]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                continue;
            } elseif ($sCheck === true && $iCheck === false) {
                $errorLists[$i] = "[商品コードが見つかりませんでした]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                continue;
            }

            $produt = ItemStore::where('store_id', $sId->id)->where('item_id', $iId->id)->first();

            // それぞれ値が存在するかチェック
            if (isset($arr['data']['rows'][$i]['price'])) {
                $price = $arr['data']['rows'][$i]['price'];
                if (!is_int($price)) {
                    // 金額チェック。整数かどうか
                    $errorLists[$i] = "[販売価格が整数ではありません]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json($price, 400);
                    // return response()->json(['message' => '400 販売価格が整数ではありません'], 400);
                    continue;
                }
            } else {
                $price = $produt->price;
            }
            if (isset($arr['data']['rows'][$i]['value'])) {
                $value = $arr['data']['rows'][$i]['value'];
                if (!is_int($value)) {
                    // 金額チェック。整数かどうか
                    $errorLists[$i] = "[セール価格が整数ではありません]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json($value, 400);
                    // return response()->json(['message' => '400 セール価格が整数ではありません'], 400);
                    continue;
                }
            } else {
                $value = $produt->value;
            }
            if (isset($arr['data']['rows'][$i]['displayFlag'])) {
                $displayFlag = $arr['data']['rows'][$i]['displayFlag'];
            }
            // 日付形式チェック
            $format_str = '%Y-%m-%d %H:%M:%S';
            if (isset($arr['data']['rows'][$i]['startDate'])) {
                $startDate = $arr['data']['rows'][$i]['startDate'];
                if (!strptime($startDate, $format_str)) {
                    $errorLists[$i] = "[開始日時の書式設定に誤りがあります]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json(['message' => '400 開始日時の書式設定に誤りがあります'], 400);
                    // return response()->json($startDate, 400);
                    continue;
                }
            } else {
                $startDate = $produt->start_date;
            }
            if (isset($arr['data']['rows'][$i]['endDate'])) {
                $endDate = $arr['data']['rows'][$i]['endDate'];
                if (!strptime($endDate, $format_str)) {
                    $errorLists[$i] = "[終了日時の書式設定に誤りがあります]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json(['message' => '400 終了日時の書式設定に誤りがあります'], 400);
                    continue;
                }
            } else {
                $endDate = $produt->end_date;
            }

            // 時間設定 終了時間が開始時間より早くないかチェック
            $dateDiff = strtotime($endDate) - strtotime($startDate);
            if ($dateDiff <= 0) {
                $errorLists[$i] = "[セール開始日時はセール終了日時よりも前の日時を入力してください]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                // return response()->json(['message' => '400 セール開始日時はセール終了日時よりも前の日時を入力してください'], 400);
                continue;
            }

            // 金額チェック。セール価格より安くないか
            //　両方nullの場合は保存しない
            if (!is_null($price) and !is_null($value)) {
                // 両方nullではない場合
                // 価格がマイナスにならないかチェック
                $priceDiff = $price - $value;
                if ($priceDiff <= 0) {
                    $errorLists[$i] = "[セール価格は販売価格よりも安い値を入力してください]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json(['message' => '400 セール価格は販売価格よりも安い値を入力してください'], 400);
                    continue;
                } else {
                    // 両方値があって正しいから保存
                    $produt->price = $price;
                    $produt->value = $value;
                }
            } elseif (is_null($price) and !is_null($value)) {
                // セール価格に値があって、販売価格がnullの場合、エラー
                $errorLists[$i] = "[セール価格を入力する場合は、販売価格を入力してください]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                // return response()->json(['message' => '400 セール価格を入力する場合は、販売価格を入力してください'], 400);
                continue;
            // } elseif (!is_null($price) and is_null($value)){
                // 販売価格に値があって、セール価格がnullの場合は、販売価格のみ保存
                $produt->price = $price;
            }

            

            if (!isset($arr['data']['rows'][0]['productId'])) {
                return response()->json(['message' => '400 productId not found'], 400);
            }

            if (isset($displayFlag)) {
                $produt->selling_flag = $displayFlag;
            }
            $produt->start_date = $startDate;
            $produt->end_date = $endDate;

            $produt->save();
        }

        // Log::debug(print_r($errorLists, true));

        if (count($errorLists) > 0) {
            $site = "商品API";
            $to = $company->company_email;
            $company_name = $company->company_name;
            Mail::to($to)->send(new DataWorkerErrorMail($company_name, $errorLists, $site));
            // Log::debug(print_r($errorLists, true));
            // return response($errorLists);
            return response(400);
        }

        // Log::debug(print_r($headerId, true));
        // Log::debug(print_r($headerToken, true));

        return response(200);
    }
}
