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

use League\Csv\CharsetConverter;
use League\Csv\Reader;
use League\Csv\Statement;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Store;


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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($upload_filename, $filename, $user, $csv_path)
    {
        $this->upload_filename = $upload_filename;
        $this->filename = $filename;
        $this->user = $user;
        $this->csv_path = $csv_path;
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

      $messages = [
        'barcode.regex' => 'barcodeは英数字で入力してください',
        'barcode.max' => 'barcodeは20桁以内で入力してください',
        'barcode.unique' => 'barcodeは他の商品と重複しない値を入力してください',
        'barcode.exists' => 'カタログに登録されていないbarcodeです',
      ];

      $csv = Reader::createFromPath(storage_path('app/'.$this->csv_path), 'r');

      $csv->setHeaderOffset(0); //ヘッダー削除
      //UTF-8に変換
      CharsetConverter::addTo($csv, 'SJIS-win', 'UTF-8');

      $error_list = [];
      $count = 1;

      foreach($csv as $row) {
        // $row = Arr::add($row, 'company_id', $cid); // バリデーションするため、company_idを配列に追加
        $bcode = ($row['barcode']);

        $rules = [
          'barcode' => ['required','string','regex:/^[a-zA-Z0-9\s]+$/','max:20',
              Rule::unique('items','barcode')->ignore($bcode,'barcode')->where('company_id', $this->user->company_id),
              // Rule::unique({テーブル名またはModel})->ignore({チェックする値}, {カラム名})
              Rule::exists('items')->where(function ($query) use ($bcode) {$query->where('global_flag', 1)->where('barcode', $bcode);
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
      if ( count($error_list) > 0 ) {
        // ファイル名設定
        $fname = $cid . '/csv/error/' . 'catalog_' . date('YmdHis') . '.txt';
        Storage::disk('public')->put($fname, "");
        $path = url('storage/'.$fname); // 公開時にはpublicなくなる？

        // Storage::disk('public')->append($fname, '※ヘッダーを除いた行数です');

        // エラーログをテキストで出力
        $err_num = 1;
        foreach($error_list as $key => $val)
          {
            $key++;
            foreach($val as $msg)
            {
              $err_num++;
              $txt_list = 'データ'. $key .'行目：' . $msg ;
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
          // $csv_path = '/public/storage/'. $fname;
          CsvFileDeleteJob::dispatch($path)->delay(now()->addDays(3));

      } else {
        // 成功時の処理
      foreach($csv as $row_data => $v) {
          // store_id取得
          // $sid = Store::where('company_id',  $this->user->company_id)->where('store_code', '=', $v['store_code'])->pluck('id');
          $str = trim(isset($v['barcode'])); // 空白ある場合は削除
          $base_item = Item::where('barcode', $str)->first();

          // 商品情報をコピー
          $item = $base_item->replicate();

          // 必要な情報を上書き
          $item->company_id = $this->user->company_id;
          $item->display_flag = 1;
          $item->category_id = null;
          $item->global_flag = 0;

          if(isset($base_item->group_code_id)){
            // 元データにグループコードがある場合
            // 元データのグループコードから、コピー先の会社ID内に同じグループ名があるか確認
            $gc = $base_item->group_code->group_code;
            $group = DB::table('group_codes')->where('company_id', $this->user->company_id)->where('group_code', $gc)->exists();

              if( $group ){
                // グループ名の登録がある場合
                $gid = GroupCode::where('company_id', $this->user->company_id)->where('group_code', $gc)->first();
                $item->group_code_id = $gid->id;
              } elseif ( !$group && isset($gc) ) {
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
          if( $base_item->sku_item_image ){
            $base_img = '/public/'. $base_item->company_id .'/images/'. $base_item->sku_item_image;
            $copy_img = '/public/'. $this->user->company_id .'/images/'. $base_item->sku_item_image;
            // 同じファイル名のファイルがあった場合は上書き
            if (Storage::exists($copy_img)) {
                Storage::delete($copy_img);
                }
            if (Storage::exists($base_img)) {
                Storage::copy( $base_img , $copy_img );
              } else {
                // ファイルが存在しない場合はnull
                $item->sku_item_image = null;
              }
          }

          $item->save();

          // 保存したIDを取得
          $last_insert_id = $item->id;
          // Itemテーブルから見つける
          $last_insert_id = Item::find($last_insert_id);
          // ストアテーブルからカンパニーIDで見つける
          $store = Store::where('company_id', $this->user->company_id)->pluck('id');
          // 中間テーブルに関連づける
          $last_insert_id->store()->attach($store);

        }
        // 成功メール送信
        Mail::to($to)->send(new CsvSuccessMail($name, $this->upload_filename));
      }

    }
}
