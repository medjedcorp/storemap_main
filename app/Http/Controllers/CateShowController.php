<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class CateShowController extends Controller
{
    public function show(Request $request)
    {
        // カテゴリのリスト取得。中間テーブルから取扱中の商品を取得
        $lists = ItemStore::where('store_id', $request->id)->where('selling_flag', 1)->select('id','item_id')->get();
        $cateLists = [];
        // 商品リストから、カテゴリIDを配列に変換
        foreach($lists as $list){
          $cateLists[] = $list->item->category_id;
        }
        // カテゴリIDからカテゴリ名を抽出
        $catelist = Category::whereIn('id', $cateLists)->where('display_flag', 1)->select('id','category_name')->get();

        $store_info = Store::find($request->id);
        $location = Store::where('id',$request->id)->selectRaw('ST_X( location ) As latitude, ST_Y( location ) As longitude')->first();
        // 店舗画像を配列に
        $img_list = [];
        if($store_info->store_img1){
          $img_list[] = $store_info->store_img1;
        }
        if($store_info->store_img2){
          $img_list[] = $store_info->store_img2;
        }
        if($store_info->store_img3){
          $img_list[] = $store_info->store_img3;
        }
        if($store_info->store_img4){
          $img_list[] = $store_info->store_img4;
        }
        if($store_info->store_img5){
          $img_list[] = $store_info->store_img5;
        }
       
        $item_id = Item::where('category_id', $request->cate_id)->select('id')->get();
        $store_data = ItemStore::whereIn('item_id', $item_id)->where('store_id', $request->id)->AllItemSort()->with('item')->get();
      
        $cate_name = Category::where('id', $request->cate_id)->first();
 
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
        return view('store', compact('store_info', 'img_list', 'catelist', 'store_items', 'count_item', 'cate_name', 'location'));

    }

}
