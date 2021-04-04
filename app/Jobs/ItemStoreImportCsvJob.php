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
use Illuminate\Validation\Rule;

use League\Csv\CharsetConverter;
use League\Csv\Reader;
use League\Csv\Statement;

use Illuminate\Http\Request;
use App\Models\ItemStore;
use App\Models\Item;
use App\Models\Store;


class ItemStoreImportCsvJob implements ShouldQueue
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
    // protected $csv_service;
    protected $csv_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($upload_filename, $filename, $user, $csv_path)
    {
        // $this->csv_service = new ItemStoreCsvImportService();
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
        'product_code.required' => 'product_codeを入力してください',
        'product_code.regex' => 'product_codeは半角英数とハイフンのみ使用可能です',
        'product_code.max' => 'product_codeは40文字以内で入力してください',
        'product_code.exists' =>  'product_codeの値が登録されていません',
        'store_code.required' => 'store_codeを入力してください',
        'store_code.regex' => 'store_codeは半角英数のみ使用可能です',
        'store_code.max' => 'store_codeは50文字以内で入力してください',
        'store_code.exists' =>  'store_codeの値が登録されていません',
        'catch_copy.max' => 'catch_copyは140文字以内で入力してください',
        'shelf_number.max' => 'shelf_numberは10文字以内で入力してください',
        // 'price_type.required' => 'price_typeを入力してください',
        'price_type.regex' => 'price_typeは0(通常価格)、1(最低価格)、2(最高価格)、のいずれかを入力してください',
        'price.integer' => 'priceは整数で入力してください',
        'price.between' => 'priceは0～9999999999の間で入力してください',
        'value.integer' => 'valueは整数で入力してください',
        'value.between' => 'valueは0～9999999999の間で入力してください',
        'value.lt' => 'valueはpriceより低い値を入力してください',
        // 'start_date.date_format' => 'start_dateは2000/01/01 00:00の形式で入力してください',
        'start_date.date' => 'start_dateは2000/01/01 00:00の形式で入力してください',
        'start_date.before' => 'start_dateはend_dateより以前の日時を入力してください',
        // 'end_date.date_format' => 'end_dateは2000/01/01 00:00の形式で入力してください',
        'end_date.date' => 'end_dateは2000/01/01 00:00の形式で入力してください',
        'end_date.after' => 'end_dateはstart_date以降の日時を入力してください',
        'sort_num.integer' => 'sort_numは整数で入力してください',
        'sort_num.max' => 'sort_numは0～9999999999の間で入力してください',
        // 'selling_flag.nullable' => 'selling_flagを入力してください',
        'selling_flag.boolean' => 'selling_flagは0(取扱なし)、または1(取扱あり)を入力してください',
        'stock_amount.integer' => 'stock_amountは整数で入力してください',
        'stock_amount.between' => 'stock_amountは0～99999999の間で入力してください',
        // 'stock_set.required' => 'stock_setを入力してください',
        'stock_set.boolean' => 'stock_setは0(在庫設定をしない)、または1(在庫設定をする)を入力してください',
      ];

      $csv = Reader::createFromPath(storage_path('app/'.$this->csv_path), 'r');

      $csv->setHeaderOffset(0); //ヘッダー削除
      //UTF-8に変換
      CharsetConverter::addTo($csv, 'SJIS-win', 'UTF-8');

      $error_list = [];
      $count = 1;

      foreach($csv as $row) {
        // dd($row);
        // $pcode = $row->product_code;
        $pcode = ($row['product_code']);
        // $scode = $row->store_code;
        $scode = ($row['store_code']);
        // var_dump($pcode);

        $rules = [
          // 商品コードが登録されてるか確認
          'product_code' =>  ['required','regex:/^[-a-zA-Z0-9]+$/','max:40',
          Rule::exists('items')->where(function ($query) use ($pcode) {
            $query->where('company_id',  $this->user->company_id)->where('product_code', $pcode);
            // $query->where('company_id',  $this->user->company_id)->where('product_code',  $row['product_code']);
          }),
          ],
          'store_code' =>  ['required','regex:/^[a-zA-Z0-9]+$/','max:50',
          Rule::exists('stores')->where(function ($query) use ($scode)  {
            $query->where('company_id',  $this->user->company_id)->where('store_code', $scode);
            // $query->where('company_id',  $this->user->company_id)->where('store_code',  $row['store_code']);
          }),
          ],
          'catch_copy' => 'nullable|string|max:140',
          'shelf_number' => 'nullable|string|max:10',
          'price_type' => 'nullable|regex:/^[0-2]$/',
          'price' => 'nullable|integer|between:0,9999999999',
          'value' => 'nullable|integer|between:0,9999999999|lt:price',
          // 'start_date' => 'nullable|date_format:Y/m/d H:i|before:end_date',
          'start_date' => 'nullable|date|before:end_date',
          // 'end_date' => 'nullable|date_format:Y/m/d H:i|after:start_date',
          'end_date' => 'nullable|date|after:start_date',
          'sort_num' => 'nullable|integer|max:9999999999',
          'selling_flag' => 'nullable|boolean',
          'stock_amount' => 'nullable|integer|between:0,99999999',
          'stock_set' => 'nullable|boolean',
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
        $fname = $cid . '/csv/error/' . 'management_' . date('YmdHis') . '.txt';
        Storage::disk('public')->put($fname, "");
        $path = url('storage/'.$fname);

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
          $csv_path = '/public/storage/'. $fname;
          CsvFileDeleteJob::dispatch($csv_path)->delay(now()->addDays(3));

      } else {
        // 成功時の処理
      foreach($csv as $row_data => $v) {
        // item_id取得。pluck('id')で取得しちゃうと、値がない場合エラーになる
          $iid = Item::where('company_id',  $this->user->company_id)->where('product_code', '=', $v['product_code'])->first();
          // $iid = Item::where('company_id',  $this->user->company_id)->where('product_code', '=', $v['product_code'])->pluck('id');

        // store_id取得
          $sid = Store::where('company_id',  $this->user->company_id)->where('store_code', '=', $v['store_code'])->first();
          // $sid = Store::where('company_id',  $this->user->company_id)->where('store_code', '=', $v['store_code'])->pluck('id');

          if (!$iid || !$sid) {
            // 登録がないときは処理をスキップ
            continue;
          } 

          // 以下入力のない場合は、nullを入力する必要あり
          // if($v['sort_num']){
          //   $snum = $v['sort_num'];
          // } else {
          //   $snum = null;
          // }
          // if($v['value']){
          //   $value = $v['value'];
          // } else {
          //   $value = null;
          // }
          // if($v['price']){
          //   $price = $v['price'];
          // } else {
          //   $price = null;
          // }
          // if($v['catch_copy']){
          //   $copy = $v['catch_copy'];
          // } else {
          //   $copy = null;
          // }
          // if($v['shelf_number']){
          //   $shelf = $v['shelf_number'];
          // } else {
          //   $shelf = null;
          // }
          // if($v['stock_amount']){
          //   $copy = $v['stock_amount'];
          // } else {
          //   $copy = null;
          // }
          // if($v['start_date']){
          //   $sdate = date('Y-m-d H:i:s', strtotime($v['start_date'] .':00' ));
          // } else {
          //   $sdate = null;
          // }
          // if($v['end_date']){
          //   $edate = date('Y-m-d H:i:s', strtotime($v['end_date'] .':00' ));
          // } else {
          //   $edate = null;
          // }

          // 保存処理。saveで対応。
          $itemstore = ItemStore::where('item_id', $iid->id)->where('store_id', $sid->id)->first();
            // dd($itemstore);
          if(isset($v['catch_copy'])){
            $itemstore->catch_copy = $v['catch_copy'];
            // dd($itemstore);
          } 
          if(isset($v['shelf_number'])){
            $itemstore->shelf_number = $v['shelf_number'];
          }
          if(isset($v['price_type'])){
            $itemstore->price_type = $v['price_type'];
          }
          if(isset($v['price'])){
            $itemstore->price = $v['price'];
          }
          if(isset($v['value'])){
            $itemstore->value = $v['value'];
          }
          if(isset($v['start_date'])){
            $itemstore->start_date = date('Y-m-d H:i:s', strtotime($v['start_date'] .':00' ));
          }
          if(isset($v['end_date'])){
            $itemstore->end_date  = date('Y-m-d H:i:s', strtotime($v['end_date'] .':00' ));
          }
          if(isset($v['sort_num'])){
            $itemstore->sort_num = $v['sort_num'];
          }
          if(isset($v['selling_flag'])){
            $itemstore->selling_flag = $v['selling_flag'];
          }
          if(isset($v['stock_amount'])){
            $itemstore->stock_amount = $v['stock_amount'];
          }
          if(isset($v['stock_set'])){
            $itemstore->stock_set = $v['stock_set'];
          }
          $itemstore->save();


          // // 保存処理。saveで対応。
          // $itemstore = ItemStore::where('item_id', $iid->id)->where('store_id', $sid->id)->first();
          // $itemstore->catch_copy = $copy;
          // $itemstore->shelf_number =$shelf;
          // $itemstore->price_type = $v['price_type'];
          // $itemstore->price = $price;
          // $itemstore->value = $value;
          // $itemstore->start_date = $sdate;
          // $itemstore->end_date = $edate;
          // $itemstore->sort_num = $snum;
          // $itemstore->selling_flag = $v['selling_flag'];
          // $itemstore->stock_amount = $v['stock_amount'];
          // $itemstore->stock_set = $v['stock_set'];
          // $itemstore->save();

          // ItemStoreを更新。なければ登録
          // ItemStore::updateOrCreate(
          //   // カテゴリを検索
          //   ['store_id' => $sid->id, 'item_id' => $iid->id ],
          //   // データがない場合は新規登録、ある場合は更新
          //   [
          //   // 'store_id' => $sid, 登録ないやつはできないからいらない？
          //   // 'item_id' => $iid,
          //   'catch_copy' =>  $copy,
          //   'shelf_number' =>$shelf,
          //   'price_type' => $v['price_type'],
          //   'price' => $price,
          //   'value' => $value,
          //   'start_date' => $sdate,
          //   'end_date' => $edate,
          //   'sort_num' => $snum,
          //   'selling_flag' => $v['selling_flag'],
          //   'stock_amount' => $v['stock_amount'],
          //   'stock_set' => $v['stock_set'],
          //   ]
          // );
        }
        // 成功メール送信
        Mail::to($to)->send(new CsvSuccessMail($name, $this->upload_filename));
      }

    }
}
