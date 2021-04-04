<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Validator;
use App\Services\PrefectureCsvImportService;
use Illuminate\Support\Facades\Mail;
use App\Mail\CsvErrorMail;
use App\Mail\CsvSuccessMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use League\Csv\CharsetConverter;
use League\Csv\Reader;
use League\Csv\Statement;

use Illuminate\Http\Request;
use App\Models\Prefecture;

class PrefectureImportCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * ジョブがタイムアウトになるまでの秒数
     * 600 = 10分
     * @var int
     */
    public $timeout = 6000;

    // protected $category;
    protected $upload_filename;
    protected $filename;
    protected $csv_service;
    protected $user;
    protected $csv_path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($upload_filename, $filename, $user, $csv_path)
    {
        $this->csv_service = new PrefectureCsvImportService();
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
      $name = $this->user->name;
      $to   = $this->user->email;

      $csv = Reader::createFromPath(storage_path('app/'.$this->csv_path), 'r');
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
        $fname = '/csv/system/error/' . date('YmdHis') . '.txt';
        Storage::disk('public')->put($fname, "");
        $path = url('storage/'.$fname);

        // Storage::disk('local')->append($fname, '※ヘッダーを除いた行数です');

        // エラーログをテキストで出力
        foreach($error_list as $key => $val)
          {
            $key += 1;
            foreach($val as $msg)
            {
              // $key++;
              $txt_list = 'データ'. $key .'行目：' . $msg ;
              Storage::disk('public')->append($fname, $txt_list);
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
        
        $lat = $v['latitude'];
        $lng = $v['longitude'];
        $location = DB::raw("ST_GeomFromText('POINT(".$lat." ".$lng.")')");

        // 新規登録のみの処理
        // $pre = new Prefecture;
        // $pre->code = $v['code'];
        // $pre->region = $v['region'];
        // $pre->city = $v['city'];
        // $pre->ward = $v['ward'];
        // $pre->location = DB::raw("ST_GeomFromText('POINT(".$lat." ".$lng.")')");
        // $pre->save();

        // // 更新処理の場合は↓
        Prefecture::updateOrCreate(
          // カテゴリを検索
          ['code' => $v['code']],
          // データがない場合は新規登録、ある場合は更新
          [
          'code' => $v['code'],
          'region' => $v['region'],
          'city' => $v['city'],
          'ward' => $v['ward'],
          'location' => $location
          ]
        );
        }
        // 成功メール送信
        Mail::to($to)->send(new CsvSuccessMail($name, $this->upload_filename));
      }
    }
}
