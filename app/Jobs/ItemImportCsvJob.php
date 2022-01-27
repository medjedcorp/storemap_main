<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use App\Mail\CsvErrorMail;
use App\Mail\CsvSuccessMail;

use League\Csv\CharsetConverter;
use League\Csv\Reader;
use League\Csv\Statement;

use App\Models\Company;
use App\Models\Item;
use App\Models\Category;
use App\Models\GroupCode;
use App\Models\Store;
use App\Models\Color;

class ItemImportCsvJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * ジョブがタイムアウトになるまでの秒数
   * 600 = 10分
   * @var int
   */
  public $timeout = 600;
  // public $timeout = 1200;

  protected $user;
  protected $upload_filename;
  protected $filename;
  protected $csv_service;
  protected $csv_path;
  protected $max_item;
  protected $company;

  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct($upload_filename, $filename, $user, $csv_path, $max_item, $company)
  {
    $this->upload_filename = $upload_filename;
    $this->filename = $filename;
    $this->user = $user;
    $this->csv_path = $csv_path;
    $this->max_item = $max_item;
    $this->company = $company;
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
    $max_item = $this->max_item;
    $company = $this->company;
    // Log::debug($company->id);

    $messages = [
      'barcode.regex' => 'barcodeは英数字で入力してください',
      'barcode.max' => 'barcodeは20桁以内で入力してください',
      'barcode.unique' => 'barcodeは他の商品と重複しない値を入力してください',
      'product_code.required' => 'product_codeを入力してください',
      'product_code.regex' => 'product_codeは半角英数とハイフンのみ使用可能です',
      'product_code.max' => 'product_codeは40桁以内で入力してください',
      'product_name.required' => 'product_nameを入力してください',
      'product_name.max' => 'product_nameは255文字内で入力してください',
      'brand_name.max' => 'brand_nameは100文字内で入力してください',
      'category_code.exists' =>  'category_codeが登録されていません',
      'category_code.max' =>  'category_codeは30文字内で入力してください',
      'category_code.regex' => 'category_codeは半角英数とハイフンのみ使用可能です',
      'original_price.integer' => 'original_priceは整数で入力してください',
      'original_price.between' => 'original_priceは0～9999999999の間で入力してください',
      'color_name.max' => 'color_nameは30文字内で入力してください',
      'size_name.max' => 'size_nameは10文字内で入力してください',
      'description.max' => 'descriptionは10000文字内で入力してください',
      'size.max' => 'sizeは10000文字内で入力してください',
      'global_flag.boolean' => 'global_flagは0(非公開)または1(公開)を入力してください',
      'color_id.integer' => 'color_idは整数で入力してください',
      'color_id.exists' => 'color_idの値が正しくありません',
      'tag.max' => 'tagは100文字内で入力してください',
      'group_code.max' => 'group_codeは40文字内で入力してください',
      'display_flag.required' => 'display_flagに0(非公開)または1(公開)を入力してください',
      'display_flag.boolean' => 'display_flagに0(非公開)または1(公開)を入力してください',
      'item_status.required' => 'item_statusに0(中古)または1(新品)を入力してください',
      'item_status.boolean' => 'item_statusに0(中古)または1(新品)を入力してください',
      // 'storemap_category_id.required' => 'storemap_category_idを入力してください',
      'storemap_category_id.integer' => 'storemap_category_idは整数で入力してください',
      'storemap_category_id.exists' => 'storemap_category_idの値が正しくありません',
      'item_img1.img_name' => '(item_img1)jpeg,png,jpg,gif形式で指定してください',
      'item_img1.max' => '(item_img1)ファイル名は100文字以内で入力してください',
      'item_img2.img_name' => '(item_img2)jpeg,png,jpg,gif形式で指定してください',
      'item_img2.max' => '(item_img2)ファイル名は100文字以内で入力してください',
      'item_img3.img_name' => '(item_img3)jpeg,png,jpg,gif形式で指定してください',
      'item_img3.max' => '(item_img3)ファイル名は100文字以内で入力してください',
      'item_img4.img_name' => '(item_img4)jpeg,png,jpg,gif形式で指定してください',
      'item_img4.max' => '(item_img4)ファイル名は100文字以内で入力してください',
      'item_img5.img_name' => '(item_img5)jpeg,png,jpg,gif形式で指定してください',
      'item_img5.max' => '(item_img5)ファイル名は100文字以内で入力してください',
      'item_img6.img_name' => '(item_img6)jpeg,png,jpg,gif形式で指定してください',
      'item_img6.max' => '(item_img6)ファイル名は100文字以内で入力してください',
      'item_img7.img_name' => '(item_img7)jpeg,png,jpg,gif形式で指定してください',
      'item_img7.max' => '(item_img7)ファイル名は100文字以内で入力してください',
      'item_img8.img_name' => '(item_img8)jpeg,png,jpg,gif形式で指定してください',
      'item_img8.max' => '(item_img8)ファイル名は100文字以内で入力してください',
      'item_img9.img_name' => '(item_img9)jpeg,png,jpg,gif形式で指定してください',
      'item_img9.max' => '(item_img9)ファイル名は100文字以内で入力してください',
      'item_img10.img_name' => '(item_img10)jpeg,png,jpg,gif形式で指定してください',
      'item_img10.max' => '(item_img10)ファイル名は100文字以内で入力してください',
    ];

    $csv = Reader::createFromPath(storage_path('app/' . $this->csv_path), 'r');

    $csv->setHeaderOffset(0); //ヘッダー削除
    //UTF-8に変換
    CharsetConverter::addTo($csv, 'SJIS-win', 'UTF-8');

    $error_list = [];
    $count = 1;

    foreach ($csv as $row) {
      $pcode = ($row['product_code']);

      $rules = [
        'barcode' => [
          'sometimes',
          'nullable',
          // 'string',
          'regex:/^[a-zA-Z0-9\s]+$/',
          'max:20',
          Rule::unique('items', 'barcode')->ignore($pcode, 'product_code')->where('company_id', $this->company->id),
          // Rule::unique({テーブル名またはModel})->ignore({チェックする値}, {カラム名})
        ],
        'product_code' => 'required|regex:/^[-a-zA-Z0-9]+$/|max:40',
        'product_name' => 'required|string|max:255',
        'brand_name' => 'nullable|string|max:100',
        'color_name' => 'nullable|string|max:30',
        'size_name' => 'nullable|string|max:10',
        'original_price' => 'nullable|integer|between:0,9999999999',
        'description' => 'nullable|string|max:10000',
        'size' => 'nullable|string|max:10000',
        'global_flag' => 'sometimes|required|boolean', // フィールドが存在するときのみバリデーションsometimes
        // 'color' => 'nullable|string|max:40',
        'tag' => 'nullable|string|max:100',
        'group_code' => 'nullable|string|max:40',
        'category_code' =>  [
          'sometimes', 'nullable', 'regex:/^[-a-zA-Z0-9]+$/', 'max:30',
          Rule::exists('categories')->where(function ($query){
            $query->where('company_id',  $this->company->id); // カテゴリコードが登録されてるか確認
          }),
        ],
        'color_id' => 'sometimes|nullable|integer|exists:colors,id',
        'display_flag' => 'nullable|boolean',
        'item_status' => 'nullable|boolean',
        'storemap_category_id' => 'sometimes|nullable|integer|exists:storemap_categories,id',
        'item_img1' => 'nullable|img_name|max:100',
        'item_img2' => 'nullable|img_name|max:100',
        'item_img3' => 'nullable|img_name|max:100',
        'item_img4' => 'nullable|img_name|max:100',
        'item_img5' => 'nullable|img_name|max:100',
        'item_img6' => 'nullable|img_name|max:100',
        'item_img7' => 'nullable|img_name|max:100',
        'item_img8' => 'nullable|img_name|max:100',
        'item_img9' => 'nullable|img_name|max:100',
        'item_img10' => 'nullable|img_name|max:100',
        // 'item_img1' => 'nullable|max:100',
        // 'item_img1' => ['regex:/^[-_a-zA-Z0-9]+.(png|jpg|jpeg|gif|)+$/'], //配列にしないとパイプ区切りがエラーになる
      ];

      $validator = Validator::make($row, $rules, $messages);
      
      // 追加バリデーション バリデーション前に起動します
      $validator->after(function ($validator) use ($row) {
        // $company = DB::table('companies')->where('id', $this->company->id)->first();
        if (array_key_exists('company_id', $row)) {
          if ($row['company_id'] != $this->company->id) {
            $validator->errors()->add('company_id', '※注意！csvのcompany_idと、サイト入力時のcompany_idが異なります');
          }
        }
        if ($this->company->gs1_company_prefix && !array_key_exists('global_flag', $row)) {
          $validator->errors()->add('global_flag', '会社設定でメーカーを選択しているため、global_flagは必須です');
        } elseif ($this->company->gs1_company_prefix && $row['global_flag'] === 1) {
          // カンパニーのGS1事業者コードを取得
          $bar_start = $this->company->gs1_company_prefix;
          // GS1事業者コードと入力されたJANの最初の値が一致するかバリデーション。エラーの場合はエラー表示
          if (!Str::startsWith($row['barcode'], $bar_start)) {
            $validator->errors()->add('barcode', 'global_flagが1の場合は、GS1事業者コード(' . $bar_start . ')から始まるbarcodeの値を登録してください');
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
      $fname = $cid . '/csv/error/' . 'items_' . date('YmdHis') . '.txt';

      // Storage::disk('public')->put($fname, "");
      $path = url('storage/' . $fname);

      // 自作関数csvErrorList呼び出し
      csvErrorList($error_list, $fname);

      // エラーメール送信処理
      Mail::to($to)->send(new CsvErrorMail($name, $path, $this->upload_filename));

      // // 3日後にファイル削除
      // $csv_path = '/public/storage/' . $fname;
      CsvFileDeleteJob::dispatch($path)->delay(now()->addDays(3));
    } else {
      $countError = false;
      // 成功時の処理
      foreach ($csv as $row_data => $v) {

        if ($this->user->role === 'admin') {
          $cid = $v['company_id'];
        }

        if (isset($v['category_code'])) {
          $cateid = Category::where('company_id', $cid)->where('category_code', $v['category_code'])->first();
        } else {
          $cateid = null;
        }

        if (isset($v['group_code'])) {
          $gid = GroupCode::where('company_id', $cid)->where('group_code', $v['group_code'])->first();
          // Log::debug($v['group_code']);
          // Log::debug($gid);
          // \Slack::send('Hello Slack!');
        } else {
          $gid = null;
        }
        if (isset($v['color_id'])) {
          $colorid = Color::where('id',  $v['color_id'])->first();
          // Log::debug($colorid);
        } else {
          $colorid = null;
        }
        // Log::debug($cateid);
        // Log::debug($gid);
        // dd($v['group_code'],$v['category_code']);
        // 登録可能件数を超えた場合のエラー処理
        // 商品数を毎回カウント
        // $limit_item = Item::where('company_id', $this->user->company_id)->whereIn('product_code', $check_code)->count();
        // 現在の商品数をカウント
        // dd($max_item);
        $now_item = Item::where('company_id', $cid)->count();
        // $now_item = Item::where('company_id', $this->user->company_id)->count();
        // 上限を超えた場合はエラー処理
        // if ($max_item <= $limit_item or $max_item <= $now_item) {

        if ($max_item <= $now_item) {
          $fname = $cid . '/csv/error/' . 'items_' . date('YmdHis') . '.txt';
          Storage::disk('public')->put($fname, "");
          $path = url('storage/' . $fname);
          $txt_list = '登録可能商品数の上限を超えたため、処理を中断しました';
          Storage::disk('public')->append($fname, $txt_list);

          // 3日後にファイル削除
          CsvFileDeleteJob::dispatch($path)->delay(now()->addDays(3));
          $countError = true;
          break;
        }
        // dd($gid,$cateid);
        // group_codeのcsvに値があって、group_codeテーブルに値がない場合の処理
        if (isset($v['group_code']) && !$gid) {
          // group_codeテーブルに値を保存
          $gcd = new GroupCode;
          $gcd->group_code = $v['group_code'];
          if ($this->user->role === 'admin') {
            $gcd->company_id = $v['company_id'];
          } else {
            $gcd->company_id = $this->user->company_id;
          }
          $gcd->save();

          // 保存したIDを取得
          $gid = $gcd;
          // $last_insert_id = $gcd->id;
          // $gid = $last_insert_id;
          // Log::debug($gid);
        }

        // Log::debug($cateid);
        // Log::debug($v);

        // メーカーフラグ用の設定
        $company = Company::find($cid);

        $item = Item::where('company_id', $cid)->where('product_code', $v['product_code'])->first();

        if (empty($item)) {
          $item = new Item;
          if (empty($v['display_flag'])) {
            $item->display_flag = 1;
          }
          if (empty($v['item_status'])) {
            $item->item_status = 1;
          }
        }
        $item->company_id = $cid;
        $item->product_code = $v['product_code'];
        $item->product_name = $v['product_name'];

        if (isset($v['brand_name'])) {
          $item->brand_name = $v['brand_name'];
        }
        if (isset($v['barcode'])) {
          $str = $v['barcode'];  // 空白ある場合は削除
          $bar = rtrim($str);  // 空白ある場合は削除
          // Log::debug($v['barcode']);
          // Log::debug($bar);
          // var_dump($bar);
          $item->barcode = $bar;

          // $item->barcode = $v['barcode'];
        }
        if (isset($v['category_code'])) {
          $item->category_id = optional($cateid)->id; // 値がない場合は空
        }
        if (isset($v['original_price'])) {
          $item->original_price = $v['original_price'];
        }
        if (isset($v['display_flag'])) {
          $item->display_flag = $v['display_flag'];
        }
        if (isset($v['description'])) {
          $item->description = $v['description'];
        }
        if (isset($v['color_name'])) {
          $item->color_name = $v['color_name'];
        }
        if (isset($v['size_name'])) {
          $item->size_name = $v['size_name'];
        }
        if (isset($v['size'])) {
          $item->size = $v['size'];
        }

        $m_flag = $company->maker_flag;

        if ($m_flag == 0) {
          // メーカーじゃない場合は全部0入れる
          $item->global_flag = 0;
        } else {
          // メーカーの場合
          $item->global_flag = $v['global_flag'];
        }

        if (isset($v['color_id'])) {
          $item->color_id = optional($colorid)->id; // 値がない場合は空
          // Log::debug($item->color_id);
          // \Slack::channel('error')->send($item->color_id);
        }

        if (isset($v['tag'])) {
          $item->tag = $v['tag'];
        }
        if (isset($v['group_code'])) {
          $item->group_code_id = optional($gid)->id; // 値がない場合は空
        }
        if (isset($v['item_status'])) {
          $item->item_status = $v['item_status'];
        }
        if (empty($v['storemap_category_id'])) {
          // issetでするとエラーになるよ。空の場合はnull入れる
          $item->storemap_category_id = null;
        } else {
          $item->storemap_category_id = $v['storemap_category_id'];
        }
        // dd($item);

        if (isset($v['item_img1'])) {
          $item->item_img1 = $v['item_img1'];
        }
        if (isset($v['item_img2'])) {
          $item->item_img2 = $v['item_img2'];
        }
        if (isset($v['item_img3'])) {
          $item->item_img3 = $v['item_img3'];
        }
        if (isset($v['item_img4'])) {
          $item->item_img4 = $v['item_img4'];
        }
        if (isset($v['item_img5'])) {
          $item->item_img5 = $v['item_img5'];
        }
        if (isset($v['item_img6'])) {
          $item->item_img6 = $v['item_img6'];
        }
        if (isset($v['item_img7'])) {
          $item->item_img7 = $v['item_img7'];
        }
        if (isset($v['item_img8'])) {
          $item->item_img8 = $v['item_img8'];
        }
        if (isset($v['item_img9'])) {
          $item->item_img9 = $v['item_img9'];
        }
        if (isset($v['item_img10'])) {
          $item->item_img10 = $v['item_img10'];
        }

        $item->save();

        // $fname = $cid . '/csv/question/' . 'items_' . date('YmdHis') . '.txt';
        // Storage::disk('public')->put($fname, "");
        // Storage::disk('public')->append($fname, $item);

        // Log::debug($item);
        // dd($item);

        $last_insert_id = $item->id;
        $iid = Item::find($last_insert_id);
        // ストアテーブルからカンパニーIDで見つける
        $store = Store::where('company_id', $item->company_id)->pluck('id');
        // 中間テーブルに関連づける
        $iid->store()->syncWithoutDetaching($store);
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
