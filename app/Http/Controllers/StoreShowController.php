<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use App\Models\Category;
use App\Models\FastEvent;
use Carbon\Carbon;
// use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Pagination\Paginator;

class StoreShowController extends Controller
{
  public function show(Request $request)
  {
    // 検索からキーワード取得
    $keyword = $request->input('keyword');

    // カテゴリのリスト取得。中間テーブルから取扱中の商品を取得
    // $time_start1 = microtime(true); 測定スタート
    $lists = ItemStore::where('store_id', $request->id)->where('selling_flag', 1)->select('id', 'item_id')->get();
    // $time1 = microtime(true) - $time_start1; 測定終了 time1秒です

    // dd($lists1,$time1,$lists2,$time2);
    $cateLists = [];
    // 商品リストから、カテゴリIDを配列に変換
    foreach ($lists as $list) {
      $cateLists[] = $list->item->category_id;
    }
    // カテゴリIDからカテゴリ名を抽出
    $catelist = Category::whereIn('id', $cateLists)->where('display_flag', 1)->select('id', 'category_name')->get();
    $cate_count = Category::whereIn('id', $cateLists)->where('display_flag', 1)->count();

    $store_info = Store::find($request->id);
    $location = Store::where('id',$request->id)->selectRaw('ST_X( location ) As latitude, ST_Y( location ) As longitude')->first();
    // 店舗画像を配列に
    $img_list = [];
    if ($store_info->store_img1) {
      $img_list[] = $store_info->store_img1;
    }
    if ($store_info->store_img2) {
      $img_list[] = $store_info->store_img2;
    }
    if ($store_info->store_img3) {
      $img_list[] = $store_info->store_img3;
    }
    if ($store_info->store_img4) {
      $img_list[] = $store_info->store_img4;
    }
    if ($store_info->store_img5) {
      $img_list[] = $store_info->store_img5;
    }

    // カレンダー用
    $fastEvents = FastEvent::where('store_id', $request->id)->get();

    if (isset($keyword)) {
      // キーワードがある商品を取得
      $store_data = ItemStore::where('store_id', $request->id)->AllItemSort()->with('item')
        ->whereIn('item_store.item_id', function ($query) use ($keyword) {
          $query->from('items')
            ->select('items.id')
            ->orWhere('items.product_code', 'like', '%' . $keyword . '%')
            ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
            ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
            ->orWhere('items.tag', 'like', '%' . $keyword . '%');
        })
        ->get();

      $store_items = storeItemSet($store_data);
      $count_item = count($store_items);
      $store_collect = collect($store_items); // 配列をコレクションに変換

      $store_items = new LengthAwarePaginator( // ページネーション作成
        $store_collect->forPage($request->page, 20), // 10単位
        count($store_collect), // 総数取得
        20, // 50に区切る
        $request->page,
        ['path' => $request->url()]
      );

      // dd($request->id,$store_info, $location,$catelist);
      return view('store', compact('store_info', 'img_list', 'catelist', 'store_items', 'count_item', 'cate_count', 'keyword', 'fastEvents', 'location'));
    } else {

      $store_data = ItemStore::where('store_id', $request->id)->AllItemSort()->with('item')->get();

      $store_items = storeItemSet($store_data);
      $count_item = count($store_items);
      $store_collect = collect($store_items); // 配列をコレクションに変換

      $store_items = new LengthAwarePaginator( // ページネーション作成
        $store_collect->forPage($request->page, 20), // 10単位
        count($store_collect), // 総数取得
        20, // 50に区切る
        $request->page,
        ['path' => $request->url()]
      );
      // dd($store_info);

      return view('store', compact('store_info', 'img_list', 'catelist', 'store_items', 'count_item', 'cate_count', 'keyword', 'fastEvents','location'));
    }
  }

  
  // public function show2(Request $request)
  // {

  //   // 検索からキーワード取得
  //   $keyword = $request->input('keyword');

  //   // カテゴリのリスト取得。中間テーブルから取扱中の商品を取得
  //   // $time_start1 = microtime(true); 測定スタート
  //   $lists = ItemStore::where('store_id', $request->id)->where('selling_flag', 1)->select('id', 'item_id')->get();
  //   // $time1 = microtime(true) - $time_start1; 測定終了 time1秒です

  //   // dd($lists1,$time1,$lists2,$time2);
  //   $cateLists = [];
  //   // 商品リストから、カテゴリIDを配列に変換
  //   foreach ($lists as $list) {
  //     $cateLists[] = $list->item->category_id;
  //   }
  //   // カテゴリIDからカテゴリ名を抽出
  //   $catelist = Category::whereIn('id', $cateLists)->where('display_flag', 1)->select('id', 'category_name')->get();

  //   $store_info = Store::find($request->id);
  //   // 店舗画像を配列に
  //   $img_list = [];
  //   if ($store_info->store_img1) {
  //     $img_list[] = $store_info->store_img1;
  //   }
  //   if ($store_info->store_img2) {
  //     $img_list[] = $store_info->store_img2;
  //   }
  //   if ($store_info->store_img3) {
  //     $img_list[] = $store_info->store_img3;
  //   }
  //   if ($store_info->store_img4) {
  //     $img_list[] = $store_info->store_img4;
  //   }
  //   if ($store_info->store_img5) {
  //     $img_list[] = $store_info->store_img5;
  //   }

  //   // カレンダー用
  //   $fastEvents = FastEvent::where('store_id', $request->id)->get();

  //   if (isset($keyword)) {
  //     // キーワードがある商品を取得
  //     $store_data = ItemStore::where('store_id', $request->id)->AllItemSort()->with('item')
  //       ->whereIn('item_store.item_id', function ($query) use ($keyword) {
  //         $query->from('items')
  //           ->select('items.id')
  //           ->orWhere('items.product_code', 'like', '%' . $keyword . '%')
  //           ->orWhere('items.product_name', 'like', '%' . $keyword . '%')
  //           ->orWhere('items.barcode', 'like', '%' . $keyword . '%')
  //           ->orWhere('items.tag', 'like', '%' . $keyword . '%');
  //       })
  //       ->get();

  //     $store_items = priceset($store_data);
  //     $count_item = count($store_items);
  //     $store_collect = collect($store_items); // 配列をコレクションに変換

  //     $store_items = new LengthAwarePaginator( // ページネーション作成
  //       $store_collect->forPage($request->page, 20), // 10単位
  //       count($store_collect), // 総数取得
  //       20, // 50に区切る
  //       $request->page,
  //       ['path' => $request->url()]
  //     );
  //     // dd($store_info);
  //     return view('store2.index', compact('store_info', 'img_list', 'catelist', 'store_items', 'count_item', 'keyword', 'fastEvents'));
  //   } else {

  //     $store_data = ItemStore::where('store_id', $request->id)->AllItemSort()->with('item')->get();

  //     $store_items = priceset($store_data);
  //     $count_item = count($store_items);
  //     $store_collect = collect($store_items); // 配列をコレクションに変換

  //     $store_items = new LengthAwarePaginator( // ページネーション作成
  //       $store_collect->forPage($request->page, 20), // 10単位
  //       count($store_collect), // 総数取得
  //       20, // 50に区切る
  //       $request->page,
  //       ['path' => $request->url()]
  //     );
  //     // dd($store_info);

  //     return view('store2.index', compact('store_info', 'img_list', 'catelist', 'store_items', 'count_item', 'keyword', 'fastEvents'));
  //   }
  // }
}
