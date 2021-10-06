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

        // 会社チェック
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

        // stock_typeが存在するかチェック
        // 0の場合絶対値
        // 1の場合相対値
        if (!isset($arr['data']['stock_type'])) {
            return response()->json(['message' => '400 stock_type not found'], 400);
        } else {
            $stockType = $arr['data']['stock_type'];
            // return response()->json(['message' => '400 Incorrect specification of stock_type ' . $stockType], 400);
            if (!($stockType === '0' or $stockType === '1')) {
                return response()->json(['message' => '400 Incorrect specification of stock_type'], 400);
            }
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

            // 絶対値か相対値で在庫の入れ方を変える
            if ($stockType === '0') {
                $produt->stock_amount = $stockAmount;
            } elseif ($stockType === '1') {
                $nowStock = $produt->stock_amount;
                $stockAmount = $nowStock + $stockAmount;
                $produt->stock_amount = $stockAmount;
            }

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
        // return response()->json($arr, 400);
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

        // 会社チェック。
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

        for ($i = 0; $i < $json_count; $i++) {
            // Log::debug(print_r($i, true));

            $productId = $arr['data']['rows'][$i]['productId'];
            $storeId =  $arr['data']['rows'][$i]['storeId'];
            $dataCheck =  $arr['data']['rows'][$i];

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
                if (!is_numeric($price)) {
                    // 金額チェック。整数かどうか
                    $errorLists[$i] = "[販売価格が整数ではありません]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json($price, 400);
                    // return response()->json(['message' => '400 販売価格が整数ではありません'], 400);
                    continue;
                }
                if ($price < 0) {
                    $errorLists[$i] = "[販売価格(price)は0以上の値を指定してください]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    continue;
                }
            } else {
                // nullか、未定義かを判定(項目自体があるかないか)
                $price_key = 'price';

                if (array_key_exists($price_key, $dataCheck)) {
                    // nullの場合は、(項目がある場合)は、価格を削除
                    $price = null;
                    // return response()->json(['message' => $valueNum], 400);
                } else {
                    // 未定義の場合は、(項目がない場合)は、前回の値を活かす
                    $price = $produt->price;
                    // return response()->json(['message' => $valueNum], 400);
                }
            }

            if (isset($arr['data']['rows'][$i]['value'])) {
                // $arr['data']['rows'][$i]['value']に値があってnullじゃない場合
                $value = $arr['data']['rows'][$i]['value'];

                if (!is_numeric($value)) {
                    // 金額チェック。整数かどうか
                    $errorLists[$i] = "[セール価格が整数ではありません]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json($value, 400);
                    // return response()->json(['message' => '400 セール価格が整数ではありません'], 400);
                    continue;
                }
                if ($value <= 0) {
                    $errorLists[$i] = "[セール価格(value)は0以上の値を指定してください]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    continue;
                }
            } else {
                // nullか、未定義かを判定(項目自体があるかないか)
                $value_key = 'value';

                if (array_key_exists($value_key, $dataCheck)) {
                    // nullの場合は、(項目がある場合)は、セール価格を削除
                    $value = null;
                    // return response()->json(['message' => $valueNum], 400);
                } else {
                    // 未定義の場合は、(項目がない場合)は、前回の値を活かす
                    $value = $produt->value;
                    // return response()->json(['message' => $valueNum], 400);
                }
            }

            // 棚番号
            if (isset($arr['data']['rows'][$i]['shelf_number'])) {
                $shelf_num = $arr['data']['rows'][$i]['shelf_number'];
            } else {
                $shelf_key = 'shelf_number';

                if (array_key_exists($shelf_key, $dataCheck)) {
                    // nullの場合は、(項目がある場合)は、棚番号を削除
                    $shelf_num = null;
                    // return response()->json(['message' => $valueNum], 400);
                } else {
                    // 未定義の場合は、(項目がない場合)は、前回の値を活かす
                    $shelf_num = $produt->shelf_number;
                    // return response()->json(['message' => $valueNum], 400);
                }
            }
            if (isset($arr['data']['rows'][$i]['displayFlag'])) {
                $displayFlag = $arr['data']['rows'][$i]['displayFlag'];
                if (!($displayFlag === '0' or $displayFlag === '1')) {
                    $errorLists[$i] = "[表示設定(displayFlag)は0または1の値を指定してください]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    continue;
                }
            } else {
                $df_key = 'displayFlag';

                if (array_key_exists($df_key, $dataCheck)) {
                    // nullの場合はエラー
                    return response()->json(['message' => '400 Specify 0 or 1 for displayFlag'], 400);
                    // return response()->json(['message' => $valueNum], 400);
                } else {
                    // 未定義の場合は、(項目がない場合)は、前回の値を活かす
                    $displayFlag = $produt->selling_flag;
                    // return response()->json(['message' => $valueNum], 400);
                }
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
                $sDate_key = 'startDate';

                if (array_key_exists($sDate_key, $dataCheck)) {
                    // nullの場合は、(項目がある場合)は、棚番号を削除
                    $startDate = null;
                } else {
                    // 未定義の場合は、(項目がない場合)は、前回の値を活かす
                    $startDate = $produt->start_date;
                }

            }
            if (isset($arr['data']['rows'][$i]['endDate'])) {
                $endDate = $arr['data']['rows'][$i]['endDate'];
                if (!strptime($endDate, $format_str)) {
                    $errorLists[$i] = "[終了日時の書式設定に誤りがあります]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json(['message' => '400 終了日時の書式設定に誤りがあります'], 400);
                    continue;
                }
            } else {
                $eDate_key = 'endDate';

                if (array_key_exists($eDate_key, $dataCheck)) {
                    // nullの場合は、(項目がある場合)は、棚番号を削除
                    $endDate = null;
                } else {
                    // 未定義の場合は、(項目がない場合)は、前回の値を活かす
                    $endDate = $produt->end_date;
                }
            }

            // 時間設定 終了時間が開始時間より早くないかチェック
            if (!is_null($startDate) and !is_null($endDate)) {
                $dateDiff = strtotime($endDate) - strtotime($startDate);
                if ($dateDiff <= 0) {
                    $errorLists[$i] = "[セール開始日時はセール終了日時よりも前の日時を入力してください]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json(['message' => '400 セール開始日時はセール終了日時よりも前の日時を入力してください'], 400);
                    continue;
                }
            }

            // 金額チェック。セール価格より安くないか
            //　両方nullの場合は、金額を削除。定価が自動で入ります
            if (!is_null($price) and !is_null($value)) {
                // 両方nullではない場合
                // 価格がマイナスにならないかチェック
                $priceDiff = $price - $value;
                if ($priceDiff <= 0) {
                    $errorLists[$i] = "[セール価格は販売価格よりも安い値を入力してください]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                    // return response()->json(['message' => '400 セール価格は販売価格よりも安い値を入力してください'], 400);
                    continue;
                }
            } elseif (is_null($price) and !is_null($value)) {
                // セール価格に値があって、販売価格がnullの場合、エラー
                $errorLists[$i] = "[セール価格を入力する場合は、販売価格を入力してください]  店舗コード：" . $storeId . " / 商品コード：" . $productId . "\n";
                // return response()->json(['message' => '400 セール価格を入力する場合は、販売価格を入力してください'], 400);
                continue;
                // 販売価格に値があって、セール価格がnullの場合は、販売価格のみ保存
                // $produt->price = $price;
            }



            // if (isset($displayFlag)) {
            //     $produt->selling_flag = $displayFlag;
            // }
            $produt->start_date = $startDate;
            $produt->end_date = $endDate;
            $produt->price = $price;
            $produt->value = $value;
            $produt->shelf_number = $shelf_num;
            $produt->selling_flag = $displayFlag;
            
            $produt->save();
        }


        if (count($errorLists) > 0) {
            $site = "商品API";
            $to = $company->company_email;
            $company_name = $company->company_name;
            Mail::to($to)->send(new DataWorkerErrorMail($company_name, $errorLists, $site));
            return response()->json($errorLists, 400);
        }
        return response(200);
    }
}
