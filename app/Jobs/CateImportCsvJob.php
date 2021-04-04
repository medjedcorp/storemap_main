<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use App\Services\CategoryCsvImportService;
use Illuminate\Support\Facades\Mail;
use App\Mail\CsvErrorMail;
use App\Mail\CsvSuccessMail;
use Illuminate\Support\Facades\Storage;

use League\Csv\CharsetConverter;
use League\Csv\Reader;
use League\Csv\Statement;

use Illuminate\Http\Request;
use App\Models\Category;


class CateImportCsvJob implements ShouldQueue
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
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($upload_filename, $filename, $user, $csv_path)
    {
        $this->csv_service = new CategoryCsvImportService();
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

      // $csv = Reader::createFromPath(storage_path('app/public/'. $cid .'/csv/import/' . $this->filename), 'r');
      $csv = Reader::createFromPath(storage_path('app/'.$this->csv_path), 'r');
      // $csv = Reader::createFromPath(storage_path('app/csv/'. $cid .'/import/' . $this->filename), 'r');
      // $csv = Reader::createFromPath(storage_path('app/public/'. $this->filename), 'r');
      $csv->setHeaderOffset(0); //ヘッダー削除

      //UTF-8に変換
      CharsetConverter::addTo($csv, 'SJIS-win', 'UTF-8');

      $error_list = [];
      $count = 1;

      foreach($csv as $row) {
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
      if ( count($error_list) > 0 ) {
        // ファイル名設定
        $fname = $cid . '/csv/error/' . 'categories_' . date('YmdHis') . '.txt';
        Storage::disk('public')->put($fname, "");
        // $path = storage_path('public/'.$fname);
        $path = url('storage/'.$fname);

        // Storage::disk('public')->append($fname, '※ヘッダーを除いた行数です');

        // エラーログをテキストで出力
        $err_num = 1;
        $error = errorlist($error_list);
        foreach($error_list as $key => $val)
          {
            $key++;
            foreach($val as $msg)
            {
              $err_num++;
              $txt_list = 'データ'. $key .'行目：' . $msg ;
              Storage::disk('public')->append($fname, $txt_list);
            }
            if($err_num > 100){
              $txt_list = 'エラー行数が100件を超えました。csvの内容を再度確認してください';
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

                  // 保存処理。saveで対応。
                  $category = Category::where('company_id', $cid)->where('category_code' , $v['category_code'])->first();

                  // $itemstore->catch_copy = $copy;
                  if(empty($category)){
                    $category = new Category;
                  }
                  $category->company_id = $cid;
                  $category->category_code = $v['category_code'];
                  
                  if(isset($v['category_name'])){
                    $category->category_name = $v['category_name'];
                  } else {
                    // 新規作成状態で値ない場合はカテゴリコードを入れちゃう
                    $category->category_name = $v['category_code'];
                  }
                  // $itemstore->shelf_number =$shelf;
                  if(isset($v['display_flag'])){
                    $category->display_flag = $v['display_flag'];
                  } else {
                    // 新規作成状態で値ない場合は1を入れちゃう
                    $category->display_flag = 1;
                  }
                  $category->save();

          // Category::updateOrCreate(
          //   // カテゴリを検索
          //   ['company_id' => $cid, 'category_code' => $v['category_code']],
          //   // データがない場合は新規登録、ある場合は更新
          //   [
          //   'company_id' => $cid,
          //   'category_code' => $v['category_code'],
          //   'category_name' => $v['category_name'],
          //   'display_flag' => $v['display_flag'],
          //   ]
          // );
        }
        // 成功メール送信
        Mail::to($to)->send(new CsvSuccessMail($name, $this->upload_filename));
      }

      // 終了後ファイル削除 動かない！なんで？
      // ファイルが使用中だからっぽい感じ
      // Storage::delete($this->csv_path);
      // CsvFileDeleteJob::dispatch($this->$csv_path)->delay(now()->addMinutes(1));

    }
}
