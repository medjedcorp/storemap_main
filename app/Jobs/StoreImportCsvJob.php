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

class StoreImportCsvJob implements ShouldQueue
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
  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($upload_filename, $filename, $user, $csv_path, $quantity)
  {
    // SevicesのStoreCsvImportServiceを呼び出し。バリデーションはこっちでしてます
    $this->csv_service = new StoreCsvImportService();
    
    $this->upload_filename = $upload_filename;
    $this->filename = $filename;
    $this->user = $user;
    $this->csv_path = $csv_path;
    $this->quantity = $quantity;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle(Request $request)
  {
    // user情報取得
    $cid  = $this->user->company_id;
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
        if($err_num > 1000){
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

        $geo = Store::where('company_id', $this->user->company_id)->where('store_code', $v['store_code'])->first();

        // 配列の中に値があるかチェック、あればtrue
        $kana_bool = in_array($store_kana, $v);
        $fax_bool = in_array($store_fax_number, $v);
        $email_bool = in_array($store_email, $v);
        $img1_bool = in_array($store_img1, $v);
        $img2_bool = in_array($store_img2, $v);
        $img3_bool = in_array($store_img3, $v);
        $img4_bool = in_array($store_img4, $v);
        $img5_bool = in_array($store_img5, $v);
        $info_bool = in_array($store_info, $v);
        $store_bool = in_array($store_url, $v);
        $flyer_bool = in_array($flyer_img, $v);
        $floor_bool = in_array($floor_guide, $v);
        $pay_info = in_array($pay_info, $v);
        $access = in_array($access, $v);
        $opening_hour = in_array($opening_hour, $v);
        $closed_day = in_array($closed_day, $v);
        $parking = in_array($parking, $v);

        // 登録可能件数を超えた場合のエラー処理
        // 店舗数を毎回カウント
        // $limit_code = Store::where('company_id', $this->user->company_id)->whereIn('store_code', $check_code)->count();
        // 現在の店舗数をカウント
        $now_code = Store::where('company_id', $this->user->company_id)->count();
        // 上限を超えた場合はエラー処理
        // if($quantity <= $limit_code or $quantity <= $now_code){
        if($quantity <= $now_code){
          $fname = $cid . '/csv/error/' . 'stores_' . date('YmdHis') . '.txt';
          Storage::disk('public')->put($fname, "");
          $path = url('storage/' . $fname);
          $txt_list = '登録可能店舗数の上限を超えたため、登録に失敗しました。現在の登録可能件数：' . $quantity . '店';
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
            if($kana_bool){
              $geo->store_kana = $v['store_kana'];
            }
            $geo->store_postcode = $v['store_postcode'];
            $geo->store_phone_number = $v['store_phone_number'];
            if($fax_bool){
              $geo->store_fax_number = $v['store_fax_number'];
            }
            if($email_bool){
              $geo->store_email = $v['store_email'];
            }
            $geo->pause_flag = $v['pause_flag'];
            if($img1_bool){
              $geo->store_img1 = $v['store_img1'];
            }
            if($img2_bool){
              $geo->store_img2 = $v['store_img2'];
            }
            if($img3_bool){
              $geo->store_img3 = $v['store_img3'];
            }
            if($img4_bool){
              $geo->store_img4 = $v['store_img4'];
            }
            if($img5_bool){
              $geo->store_img5 = $v['store_img5'];
            }
            if($info_bool){
              $geo->store_info = $v['store_info'];
            }
            $geo->industry_id = $v['industry_id'];
            if($store_bool){
              $geo->store_url = $v['store_url'];
            }
            if($flyer_bool){
              $geo->flyer_img = $v['flyer_img'];
            }
            if($floor_bool){
              $geo->floor_guide = $v['floor_guide'];
            }
            if($pay_info){
              $geo->pay_info = $v['pay_info'];
            }
            if($access){
              $geo->floor_guide = $v['access'];
            }
            if($opening_hour){
              $geo->floor_guide = $v['opening_hour'];
            }
            if($closed_day){
              $geo->floor_guide = $v['closed_day'];
            }
            if($parking){
              $geo->floor_guide = $v['parking'];
            }
            $geo->save();

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
            if($kana_bool){
              $geo->store_kana = $v['store_kana'];
            }
            $geo->store_postcode = $v['store_postcode'];
            $geo->prefecture = $v['prefecture'];
            $geo->store_city = $v['store_city'];
            $geo->store_adnum = $v['store_adnum'];
            $geo->store_apart = $v['store_apart'];
            $geo->store_phone_number = $v['store_phone_number'];
            if($fax_bool){
              $geo->store_fax_number = $v['store_fax_number'];
            }
            if($email_bool){
              $geo->store_email = $v['store_email'];
            }
            $geo->pause_flag = $v['pause_flag'];
            if($img1_bool){
              $geo->store_img1 = $v['store_img1'];
            }
            if($img2_bool){
              $geo->store_img2 = $v['store_img2'];
            }
            if($img3_bool){
              $geo->store_img3 = $v['store_img3'];
            }
            if($img4_bool){
              $geo->store_img4 = $v['store_img4'];
            }
            if($img5_bool){
              $geo->store_img5 = $v['store_img5'];
            }
            if($info_bool){
              $geo->store_info = $v['store_info'];
            }
            $geo->industry_id = $v['industry_id'];
            if($store_bool){
              $geo->store_url = $v['store_url'];
            }
            if($flyer_bool){
              $geo->flyer_img = $v['flyer_img'];
            }
            if($floor_bool){
              $geo->floor_guide = $v['floor_guide'];
            }
            if($pay_info){
              $geo->pay_info = $v['pay_info'];
            }
            if($access){
              $geo->access = $v['access'];
            }
            if($opening_hour){
              $geo->opening_hour = $v['opening_hour'];
            }
            if($closed_day){
              $geo->closed_day = $v['closed_day'];
            }
            if($parking){
              $geo->floor_guide = $v['parking'];
            }
            $geo->location = DB::raw("ST_GeomFromText('POINT(" . $lat . " " . $lng . ")')");
            // $geo->latitude = $latitude;
            // $geo->longitude = $longitude;
            $geo->save();

            // store_codeを配列に保存
            // $check_code[] = $geo->store_code;
          }
        } else {
          // geo に値がないときジオコーディングして新規保存
          if($v['store_apart']){
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
          $store->company_id = $this->user->company_id;
          $store->store_code = $v['store_code'];
          $store->store_name = $v['store_name'];
          // if($store_kana){
          //   $store->store_kana = $store_kana;
          // }
          if($kana_bool){
            $store->store_kana = $v['store_kana'];
          }
          $store->store_postcode = $v['store_postcode'];
          $store->prefecture = $v['prefecture'];
          $store->store_city = $v['store_city'];
          $store->store_adnum = $v['store_adnum'];
          $store->store_apart = $v['store_apart'];
          $store->store_phone_number = $v['store_phone_number'];
          if($fax_bool){
            $store->store_fax_number = $v['store_fax_number'];
          }
          if($email_bool){
            $store->store_email = $v['store_email'];
          }
          $store->pause_flag = $v['pause_flag'];

          if($img1_bool){
            $store->store_img1 = $v['store_img1'];
          }
          if($img2_bool){
            $store->store_img2 = $v['store_img2'];
          }
          if($img3_bool){
            $store->store_img3 = $v['store_img3'];
          }
          if($img4_bool){
            $store->store_img4 = $v['store_img4'];
          }
          if($img5_bool){
            $store->store_img5 = $v['store_img5'];
          }
          if($info_bool){
            $store->store_info = $v['store_info'];
          }
          $store->industry_id = $v['industry_id'];
          if($store_bool){
            $store->store_url = $v['store_url'];
          }
          if($flyer_bool){
            $store->flyer_img = $v['flyer_img'];
          }
          if($floor_bool){
            $store->floor_guide = $v['floor_guide'];
          }
          if($pay_info){
            $store->pay_info = $v['pay_info'];
          }
          if($access){
            $store->access = $v['access'];
          }
          if($opening_hour){
            $store->opening_hour = $v['opening_hour'];
          }
          if($closed_day){
            $store->closed_day = $v['closed_day'];
          }
          if($parking){
            $store->floor_guide = $v['parking'];
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
