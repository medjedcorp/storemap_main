<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use App\Services\StoreCsvImportService;
use Illuminate\Support\Facades\Mail;
use App\Mail\CsvErrorMail;
use App\Mail\CsvSuccessMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use League\Csv\CharsetConverter;
use League\Csv\Reader;
use League\Csv\Statement;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;

use Laravel\Cashier\Cashier;
use Log;

class StoreImportCsvJob2 implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * ジョブがタイムアウトになるまでの秒数
   * 600 = 10分
   * @var int
   */
  public $timeout = 600;

  // protected $category;
  protected $user;
  protected $upload_filename;
  protected $filename;
  protected $csv_service;
  protected $csv_path;
  protected $quantity;
  protected $cid;
  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($upload_filename, $filename, $user, $csv_path, $quantity, $cid)
  {
    // SevicesのStoreCsvImportServiceを呼び出し。バリデーションはこっちでしてます
    $this->csv_service = new StoreCsvImportService();

    $this->upload_filename = $upload_filename;
    $this->filename = $filename;
    $this->user = $user;
    $this->csv_path = $csv_path;
    $this->quantity = $quantity;
    $this->cid = $cid;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle(Request $request)
  {
    // user情報取得
    $cid  = $this->cid;
    $name = $this->user->name;
    $to   = $this->user->email;
    $quantity = $this->quantity;

    // 一時保存したcsvを取得
    $csv = Reader::createFromPath(storage_path('app/' . $this->csv_path), 'r');
    $csv->setHeaderOffset(0); //ヘッダー削除

    //UTF-8に変換
    CharsetConverter::addTo($csv, 'SJIS-win', 'UTF-8');

    $error_list = [];
    $count = 1;

    foreach ($csv as $row) {
      //csv_serviceの中のバリデーション
      $validator = Validator::make(
        $row,
        $this->csv_service->validationRules(),
        $this->csv_service->validationMessages(),
        $this->csv_service->validationAttributes()
      );

      // 追加バリデーション バリデーション前に起動します
      $validator->after(function ($validator) use ($row) {
        if (array_key_exists('company_id', $row)) {
          if ($row['company_id'] != $cid) {
            $validator->errors()->add('company_id', '※注意！csvのcompany_idと、サイト入力時のcompany_idが異なります');
          }
        }
      });


      if ($validator->fails() === true) {
        $error_list[$count] = $validator->errors()->all();
      }
      $count++;
    }

    // エラーがあれば終わり
    if (count($error_list) > 0) {
      // ファイル名設定
      $fname = $cid . '/csv/error/' . 'stores_' . date('YmdHis') . '.txt';
      Storage::disk('public')->put($fname, "");
      $path = url('storage/' . $fname);

      // Storage::disk('public')->append($fname, '※ヘッダーを除いた行数です');

      // エラーログをテキストで出力
      $err_num = 1;
      foreach ($error_list as $key => $val) {
        $key++;
        foreach ($val as $msg) {
          $err_num++;
          $txt_list = 'データ' . $key . '行目：' . $msg;
          Storage::disk('public')->append($fname, $txt_list);
        }
        if ($err_num > 1000) {
          $txt_list = 'エラー件数が1000件を超えました。csvの内容を再度確認してください';
          Storage::disk('public')->append($fname, $txt_list);
          break;
        }
      }

      // エラーメール送信処理
      Mail::to($to)->send(new CsvErrorMail($name, $path, $this->upload_filename));

      // // 3日後にファイル削除
      // $csv_path = '/public/' . $fname;
      CsvFileDeleteJob::dispatch($path)->delay(now()->addDays(3));
    } else {
      // 成功時の処理

      // 店舗数チェック用の空の配列作成
      // $check_code = [];
      // 列がなくてもOKな項目
      $store_kana = 'store_kana';
      $store_fax_number = 'store_fax_number';
      $store_email = 'store_email';
      $store_img1 = 'store_img1';
      $store_img2 = 'store_img2';
      $store_img3 = 'store_img3';
      $store_img4 = 'store_img4';
      $store_img5 = 'store_img5';
      $store_info = 'store_info';
      $store_url = 'store_url';
      $flyer_img = 'flyer_img';
      $floor_guide = 'floor_guide';
      $pay_info = 'pay_info';
      $access = 'access';
      $opening_hour = 'opening_hour';
      $closed_day = 'closed_day';
      $parking = 'parking';

      foreach ($csv as $row_data => $v) {

        $geo = Store::where('company_id', $cid)->where('store_code', $v['store_code'])->first();

        // 登録可能件数を超えた場合のエラー処理
        // 店舗数を毎回カウント
        // 現在の店舗数をカウント
        $now_code = Store::where('company_id', $cid)->count();
        // 上限を超えた場合はエラー処理
        // if($quantity <= $limit_code or $quantity <= $now_code){
        // dd($geo);
        if ($quantity < $now_code) {
          $fname = $cid . '/csv/error/' . 'stores_' . date('YmdHis') . '.txt';
          Storage::disk('public')->put($fname, "");
          $path = url('storage/' . $fname);
          $txt_list = '登録可能店舗数の上限を超えたため、処理を中断しました';
          Storage::disk('public')->append($fname, $txt_list);
          // エラーメール送信処理
          Mail::to($to)->send(new CsvErrorMail($name, $path, $this->upload_filename));
          // 3日後にファイル削除
          // $csv_path = '/public/' . $fname;
          // CsvFileDeleteJob::dispatch($csv_path)->delay(now()->addDays(3));
          CsvFileDeleteJob::dispatch($path)->delay(now()->addDays(3));
          break;
        }

        if (isset($geo)) {
          // $geoに値があるとき

          if ($geo->prefecture == $v['prefecture'] || $geo->store_city == $v['store_city'] || $geo->store_adnum == $v['store_adnum'] || $geo->store_apart == $v['store_apart']) {
            // 住所を比較して同じだった場合はジオコーディングせずに保存
            $geo->store_name = $v['store_name'];
            if (isset($v['store_kana'])) {
              $geo->store_kana = $v['store_kana'];
            }
            $geo->store_postcode = $v['store_postcode'];
            $geo->store_phone_number = $v['store_phone_number'];
            if (isset($v['store_fax_number'])) {
              $geo->store_fax_number = $v['store_fax_number'];
            }
            if (isset($v['store_email'])) {
              $geo->store_email = $v['store_email'];
            }
            $geo->pause_flag = $v['pause_flag'];
            if (isset($v['store_img1'])) {
              $geo->store_img1 = $v['store_img1'];
            }
            if (isset($v['store_img2'])) {
              $geo->store_img2 = $v['store_img2'];
            }
            if (isset($v['store_img3'])) {
              $geo->store_img3 = $v['store_img3'];
            }
            if (isset($v['store_img4'])) {
              $geo->store_img4 = $v['store_img4'];
            }
            if (isset($v['store_img5'])) {
              $geo->store_img5 = $v['store_img5'];
            }
            if (isset($v['store_info'])) {
              $geo->store_info = $v['store_info'];
            }
            $geo->industry_id = $v['industry_id'];
            if (isset($v['store_url'])) {
              $geo->store_url = $v['store_url'];
            }
            if (isset($v['flyer_img'])) {
              $geo->flyer_img = $v['flyer_img'];
            }
            if (isset($v['floor_guide'])) {
              $geo->floor_guide = $v['floor_guide'];
            }
            if (isset($v['pay_info'])) {
              $geo->pay_info = $v['pay_info'];
            }
            if (isset($v['access'])) {
              $geo->access = $v['access'];
            }
            if (isset($v['opening_hour'])) {
              $geo->opening_hour = $v['opening_hour'];
            }
            if (isset($v['closed_day'])) {
              $geo->closed_day = $v['closed_day'];
            }
            if (isset($v['parking'])) {
              $geo->parking = $v['parking'];
            }
            $geo->save();
            // dd($geo);
            // store_codeを配列に保存
            // $check_code[] = $geo->store_code;

          } else {

            // 住所違う場合はジオコーディングして保存
            $address = $v['prefecture'] . $v['store_city'] . $v['store_adnum'] . $v['store_apart'];
            $myKey = config('const.geo_key');
            $address = urlencode($address);
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "+CA&key=" . $myKey;
            $contents = file_get_contents($url);
            $jsonData = json_decode($contents, true);
            // $latitude  = $jsonData["results"][0]["geometry"]["location"]["lat"];
            // $longitude  = $jsonData["results"][0]["geometry"]["location"]["lng"];
            $lat = $jsonData["results"][0]["geometry"]["location"]["lat"];
            $lng = $jsonData["results"][0]["geometry"]["location"]["lng"];

            $geo->store_name = $v['store_name'];
            if (isset($v['store_kana'])) {
              $geo->store_kana = $v['store_kana'];
            }
            $geo->store_postcode = $v['store_postcode'];
            $geo->prefecture = $v['prefecture'];
            $geo->store_city = $v['store_city'];
            $geo->store_adnum = $v['store_adnum'];
            $geo->store_apart = $v['store_apart'];
            $geo->store_phone_number = $v['store_phone_number'];
            if (isset($v['store_fax_number'])) {
              $geo->store_fax_number = $v['store_fax_number'];
            }
            if (isset($v['store_email'])) {
              $geo->store_email = $v['store_email'];
            }
            $geo->pause_flag = $v['pause_flag'];
            if (isset($v['store_img1'])) {
              $geo->store_img1 = $v['store_img1'];
            }
            if (isset($v['store_img2'])) {
              $geo->store_img2 = $v['store_img2'];
            }
            if (isset($v['store_img3'])) {
              $geo->store_img3 = $v['store_img3'];
            }
            if (isset($v['store_img4'])) {
              $geo->store_img4 = $v['store_img4'];
            }
            if (isset($v['store_img5'])) {
              $geo->store_img5 = $v['store_img5'];
            }
            if (isset($v['store_info'])) {
              $geo->store_info = $v['store_info'];
            }
            $geo->industry_id = $v['industry_id'];
            if (isset($v['store_url'])) {
              $geo->store_url = $v['store_url'];
            }
            if (isset($v['flyer_img'])) {
              $geo->flyer_img = $v['flyer_img'];
            }
            if (isset($v['floor_guide'])) {
              $geo->floor_guide = $v['floor_guide'];
            }
            if (isset($v['pay_info'])) {
              $geo->pay_info = $v['pay_info'];
            }
            if (isset($v['access'])) {
              $geo->access = $v['access'];
            }
            if (isset($v['opening_hour'])) {
              $geo->opening_hour = $v['opening_hour'];
            }
            if (isset($v['closed_day'])) {
              $geo->closed_day = $v['closed_day'];
            }
            if (isset($v['parking'])) {
              $geo->parking = $v['parking'];
            }
            $geo->location = DB::raw("ST_GeomFromText('POINT(" . $lat . " " . $lng . ")')");
            // $geo->latitude = $latitude;
            // $geo->longitude = $longitude;
            $geo->save();

            // store_codeを配列に保存
            // $check_code[] = $geo->store_code;
          }
        } else {
          // dd($v);
          // geo に値がないときジオコーディングして新規保存
          if ($v['store_apart']) {
            $address = $v['prefecture'] . $v['store_city'] . $v['store_adnum'] . $v['store_apart'];
          } else {
            $address = $v['prefecture'] . $v['store_city'] . $v['store_adnum'];
          }

          // $myKey = env('GOOGLE_MAPS_API_KEY');
          $myKey = config('const.geo_key');
          // var_dump($myKey);
          $address = urlencode($address);
          // var_dump($address);
          $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "+CA&key=" . $myKey;
          $contents = file_get_contents($url);
          // var_dump($contents);
          $jsonData = json_decode($contents, true);
          // var_dump($jsonData);
          // Log::debug($jsonData);
          // dd($jsonData);
          $lat = $jsonData["results"][0]["geometry"]["location"]["lat"];
          $lng = $jsonData["results"][0]["geometry"]["location"]["lng"];

          $store = new Store;
          if ($this->user->role === 'admin') {
            $store->company_id = $v['company_id'];
          } else {
            $store->company_id = $cid;
          }
          $store->store_code = $v['store_code'];
          $store->store_name = $v['store_name'];
          // Log::debug($v);
          if (isset($v['store_kana'])) {
            $geo->store_kana = $v['store_kana'];
          }
          $store->store_postcode = $v['store_postcode'];
          $store->prefecture = $v['prefecture'];
          $store->store_city = $v['store_city'];
          $store->store_adnum = $v['store_adnum'];
          $store->store_apart = $v['store_apart'];
          $store->store_phone_number = $v['store_phone_number'];
          if (isset($v['store_fax_number'])) {
            $geo->store_fax_number = $v['store_fax_number'];
          }
          if (isset($v['store_email'])) {
            $geo->store_email = $v['store_email'];
          }
          $store->pause_flag = $v['pause_flag'];
          if (isset($v['store_img1'])) {
            $geo->store_img1 = $v['store_img1'];
          }
          if (isset($v['store_img2'])) {
            $geo->store_img2 = $v['store_img2'];
          }
          if (isset($v['store_img3'])) {
            $geo->store_img3 = $v['store_img3'];
          }
          if (isset($v['store_img4'])) {
            $geo->store_img4 = $v['store_img4'];
          }
          if (isset($v['store_img5'])) {
            $geo->store_img5 = $v['store_img5'];
          }
          if (isset($v['store_info'])) {
            $geo->store_info = $v['store_info'];
          }
          $store->industry_id = $v['industry_id'];
          if (isset($v['store_url'])) {
            $geo->store_url = $v['store_url'];
          }
          if (isset($v['flyer_img'])) {
            $geo->flyer_img = $v['flyer_img'];
          }
          if (isset($v['floor_guide'])) {
            $geo->floor_guide = $v['floor_guide'];
          }
          if (isset($v['pay_info'])) {
            $geo->pay_info = $v['pay_info'];
          }
          if (isset($v['access'])) {
            $geo->access = $v['access'];
          }
          if (isset($v['opening_hour'])) {
            $geo->opening_hour = $v['opening_hour'];
          }
          if (isset($v['closed_day'])) {
            $geo->closed_day = $v['closed_day'];
          }
          if (isset($v['parking'])) {
            $geo->parking = $v['parking'];
          }
          // $store->latitude = $latitude;
          // $store->longitude = $longitude;
          $store->location = DB::raw("ST_GeomFromText('POINT(" . $lat . " " . $lng . ")')");
          $store->save();

          //$last_insert_id で最後に入力したIDを取得
          // 取得したIDを使って、中間テーブルでITEMと紐付け
          $last_insert_id = $store->id;
          $last_insert_id = Store::find($last_insert_id);
          $item = Item::where('company_id', $store->company_id)->pluck('id');
          // attach だとstore_idとitem_idが逆につくからダメ…
          for ($i = 0, $num_inputs = count($item); $i < $num_inputs; $i++) {
            // $num_inputsに１回値を保存した方が早いらしい
            // for($i = 0 ; $i < count($item); $i++){
            $item_store = new ItemStore;
            $item_store->item_id = $item[$i];
            $item_store->store_id = $last_insert_id->id;
            $item_store->save();
          }

          $datum = [
            ['title' => 'Open', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#007bff', 'store_id' => $last_insert_id->id],
            ['title' => 'Reserved', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#ffc107', 'store_id' => $last_insert_id->id],
            ['title' => 'Event', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#28a745', 'store_id' => $last_insert_id->id],
            ['title' => 'Closed', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#dc3545', 'store_id' => $last_insert_id->id],
            ['title' => 'Information', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#6c757d', 'store_id' => $last_insert_id->id]
          ];
          DB::table('fast_events')->insert($datum);

          // store_codeを配列に保存
          // $check_code[] = $v['store_code'];
        }
      }
      // 成功メール送信
      Mail::to($to)->send(new CsvSuccessMail($name, $this->upload_filename));
    }
  }
}