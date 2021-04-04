<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use DB;
use Carbon\Carbon;

class AjaxItemListController extends Controller
{
  public function index(Request $request)
  {

    // キーワードと店舗を取得 URLの文字コードをUTF-8に変換
    $keyword =  mb_convert_encoding($request->keyword, "UTF-8", "auto");
    $sid = mb_convert_encoding($request->id, "UTF-8", "auto");

    // $stringdata = mb_detect_encoding($sid);
    // dd($stringdata);

    $store = Store::find($sid);

    $items = ItemStore::where('store_id', $sid)
      ->where('selling_flag', '=', '1')->with('item')->with('store')
      ->whereIn('item_store.item_id', function ($query) use ($keyword) {
        $query->from('items')
          ->select('items.id')
          ->orWhere('items.product_code', 'like', '%' . $keyword . '%')
          ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
          ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
          ->orWhere('items.tag', 'like', '%' . $keyword . '%');
      })
      ->orderByRaw('sort_num IS NULL ASC') // Nullは最後尾に
      ->orderBy('sort_num', 'ASC') //遠い順、近い順
      ->get();

    // dd($items);

    $itemsLists = array();

    foreach ($items as $item) {
      if (isset($item->start_date) and isset($item->end_date)) {
        $start_date = new Carbon($item->start_date); // セール開始時刻を取得
        $end_date = new Carbon($item->end_date); // セール終了時刻を取得
      } else {
        $start_date = NULL;
        $end_date = NULL;
      }

      $now = Carbon::now(); // 現在時刻を取得

      if (Carbon::parse($now)->between($start_date, $end_date) and isset($item->value)) {
        // 開始時刻と終了時刻の間に現在時刻があり、セール価格に登録がある場合
        $price_num = number_format($item->value); //３桁区切り
        switch ($item->price_type) {
            // セール価格を出力
          case '0':
            $price = 'SALE:<span class="price">' . $price_num . '</span>円';
            break;
          case '1':
            $price = 'SALE:～<span class="price">' . $price_num . '</span>円';
            break;
          case '2':
            $price = 'SALE:<span class="price">' . $price_num . '</span>円～';
            break;
        }
      } else {
        //　それ以外の場合
        if (isset($item->price)) {
          // 通常価格が設定されている場合
          $price_num = number_format($item->price); //３桁区切り
          switch ($item->price_type) {
            case '0':
              $price = '価格:<span class="price">' . $price_num . '</span>円';
              break;
            case '1':
              $price = '価格:～<span class="price">' . $price_num . '</span>円';
              break;
            case '2':
              $price = '価格:<span class="price">' . $price_num . '</span>円～';
              break;
          }
        } elseif (isset($item->item->original_price)) {
          //　通常価格に設定がない場合、定価を出力
          $price_num = number_format($item->item->original_price); //３桁区切り
          $price = '定価:<span class="price">' . $price_num . '</span>円';
        } else {
          // 定価の設定も空欄の場合
          $price = 'オープン価格';
        }
      }


        if($item->stock_set === 0){
          $stocks = '在庫：要問合せ';
        } elseif ($item->stock_amount > 10 and $item->stock_set === 1) {
          $stocks = '在庫：◎';
        } elseif ($item->stock_amount > 0 and $item->stock_amount <= 5 and $item->stock_set === 1) {
          $stocks = '在庫：△';
        } elseif ($item->stock_amount <= 0 and $item->stock_set === 1) {
          $stocks = '在庫：なし';
        } else {
          $stocks = '在庫：要問合せ';
        } 
      
      // 在庫情報設定。在庫０個で在庫設定する場合は、在庫なしを表示
      // if ($item->stock_amount < 1 and $item->stock_set === 1) {
      //   $stock = '&nbsp;/&nbsp;<span class="text-danger p-1"><i class="fas fa-backspace fa-flip-horizontal"></i>&nbsp;在庫なし</span>';
      // } else {
      //   $stock = '';
      // }

      $itemsLists[] = array(
        'id' => $item->id,
        'store_name' => $item->store->store_name,
        'product_code' => $item->item->product_code,
        'product_name' => $item->item->product_name,
        'store_img1' => $store->store_img1,
        'item_img1' => $item->item->item_img1,
        'company_id' => $item->item->company_id,
        'price' => $price,
        'shelf_number' => $item->shelf_number,
        'updated_at' => $item->updated_at,
        'keyword' => $keyword,
        'stocks' => $stocks
        // 'stock' => $stock
      );
    }

    return $itemsLists;
  }
}
