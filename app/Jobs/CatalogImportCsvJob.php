<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CsvErrorMail;
use App\Mail\CsvSuccessMail;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use League\Csv\CharsetConverter;
use League\Csv\Reader;
use League\Csv\Statement;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Store;
use App\Models\GroupCode;


class CatalogImportCsvJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * ジョブがタイムアウトになるまでの秒数
   * 600 = 10分
   * @var int
   */
  public $timeout = 1200;

  protected $user;
  protected $upload_filename;
  protected $filename;
  protected $csv_service;
  protected $csv_path;
  protected $max_item;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($upload_filename, $filename, $user, $csv_path, $max_item)
  {
    $this->upload_filename = $upload_filename;
    $this->filename = $filename;
    $this->user = $user;
    $this->csv_path = $csv_path;
    $this->max_item = $max_item;
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
    $max_item   = $this->max_item;

    $messages = [
      'barcode.regex' => 'barcodeは英数字で入力してください',
      'barcode.max' => 'barcodeは20桁以内で入力してください',
      'barcode.unique' => 'barcodeは他の商品と重複しない値を入力してください',
      'barcode.exists' => 'カタログに登録されていないbarcodeです',
    ];

    $csv = Reader::createFromPath(storage_path('app/' . $this->csv_path), 'r');

    $csv->setHeaderOffset(0); //ヘッダー削除
    //UTF-8に変換
    CharsetConverter::addTo($csv, 'SJIS-win', 'UTF-8');

    $error_list = [];
    $count = 1;

    foreach ($csv as $row) {
      // $row = Arr::add($row, 'company_id', $cid); // バリデーションするため、company_idを配列に追加
      $bcode = ($row['barcode']);
      $trmBcode = trim($bcode); // 空白ある場合は削除

      $rules = [
        'barcode' => [
          'required', 'string', 'regex:/^[a-zA-Z0-9\s]+$/', 'max:20',
          Rule::unique('items', 'barcode')->where('company_id', $this->user->company_id),
          // Rule::unique('items', 'barcode')->ignore($trmBcode, 'barcode')->where('company_id', $this->user->company_id),
          // Rule::unique({テーブル名またはModel})->ignore({チェックする値}, {カラム名})
          Rule::exists('items')->where(function ($query) use ($trmBcode) {
            $query->where('global_flag', 1)->where('barcode', $trmBcode);
            // itemsのグローバルフラグ1の商品で同じバーコードあるかチェック
          }),
        ],
      ];

      $validator = Validator::make($row, $rules, $messages);

      if ($validator->fails() === true) {
        $error_list[$count] = $validator->errors()->all();
      }

      $count++;
    }

    // エラーがあれば終わり
    if (count($error_list) > 0) {
      // ファイル名設定
      $fname = $cid . '/csv/error/' . 'catalog_' . date('YmdHis') . '.txt';
      Storage::disk('public')->put($fname, "");
      $path = url('storage/' . $fname); // 公開時にはpublicなくなる？

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
      // $csv_path = '/public/storage/'. $fname;
      CsvFileDeleteJob::dispatch($path)->delay(now()->addDays(3));
    } else {
      $countError = false;
      // 成功時の処理
      foreach ($csv as $row_data => $v) {

        $now_item = Item::where('company_id', $cid)->count();
        // $now_item = Item::where('company_id', $this->user->company_id)->count();
        // 上限を超えた場合はエラー処理
        // if ($max_item <= $limit_item or $max_item <= $now_item) {

        if ($max_item <= $now_item) {
          $fname = $cid . '/csv/error/' . 'catalog_' . date('YmdHis') . '.txt';
          Storage::disk('public')->put($fname, "");
          $path = url('storage/' . $fname);
          $txt_list = '登録可能商品数の上限を超えたため、処理を中断しました';
          Storage::disk('public')->append($fname, $txt_list);
          // 3日後にファイル削除
          CsvFileDeleteJob::dispatch($path)->delay(now()->addDays(3));
          $countError = true;
          break;
        }

        $bar = $v['barcode'];
        $str = trim($bar); // 空白ある場合は削除
        // $str = trim(isset($v['barcode'])); // 空白ある場合は削除
        $base_item = Item::where('global_flag', 1)->where('barcode', $str)->first();
        // dd($v['barcode'],$bar,$base_item,$str);

        // 商品情報をコピー
        $item = $base_item->replicate();

        // 必要な情報を上書き
        $item->company_id = $this->user->company_id;
        $item->display_flag = 1;
        $item->category_id = null;
        $item->global_flag = 0;

        if (isset($base_item->group_code_id)) {
          // 元データにグループコードがある場合
          // 元データのグループコードから、コピー先の会社ID内に同じグループ名があるか確認
          $gc = $base_item->group_code->group_code;
          $group = DB::table('group_codes')->where('company_id', $this->user->company_id)->where('group_code', $gc)->exists();

          if ($group) {
            // グループ名の登録がある場合
            $gid = GroupCode::where('company_id', $this->user->company_id)->where('group_code', $gc)->first();
            $item->group_code_id = $gid->id;
          } elseif (!$group && isset($gc)) {
            // グループ名の登録がなくて、グループ名が入力されている場合の処理
            $gcd = new GroupCode;
            $gcd->group_code = $gc;
            $gcd->company_id = $this->user->company_id;
            $gcd->save();
            // 保存したIDを取得
            $last_insert_id = $gcd->id;
            $item->group_code_id = $last_insert_id;
          }
        } else {
          //グループコード未記入の場合の処理
          $item->group_code_id = null;
        }

        // 画像をコピー
        if ($base_item->sku_item_image) {
          $base_img = '/public/' . $base_item->company_id . '/images/' . $base_item->sku_item_image;
          $copy_img = '/public/' . $this->user->company_id . '/images/' . $base_item->sku_item_image;
          // 同じファイル名のファイルがあった場合は上書き
          if (Storage::exists($copy_img)) {
            Storage::delete($copy_img);
          }
          if (Storage::exists($base_img)) {
            Storage::copy($base_img, $copy_img);
          } else {
            // ファイルが存在しない場合はnull
            $item->sku_item_image = null;
          }
        }

        // 今ここを作ってます。
        // 重複があるとエラーになるから、どうするか対応検討中
        // dd($item);
        $item->save();

        Item::updateOrCreate(
          // カテゴリを検索
          ['company_id' => $item->company_id, 'barcode' => $item->barcode],
          // データがない場合は新規登録、ある場合は更新
          [
            'company_id' => $item->company_id,
            'barcode' => $item->barcode,

          ]
        );

        // 保存したIDを取得
        $last_insert_id = $item->id;
        // Itemテーブルから見つける
        $last_insert_id = Item::find($last_insert_id);
        // ストアテーブルからカンパニーIDで見つける
        $store = Store::where('company_id', $this->user->company_id)->pluck('id');
        // 中間テーブルに関連づける
        $last_insert_id->store()->attach($store);
      }


      if ($countError) {
        // 登録件数オーバーの場合エラーメール送信処理
        Mail::to($to)->send(new CsvErrorMail($name, $path, $this->upload_filename));
      } else {
        // 成功メール送信
        Mail::to($to)->send(new CsvSuccessMail($name, $this->upload_filename));
      }
    }
  }
}
