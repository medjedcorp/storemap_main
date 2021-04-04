<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use App\Http\Requests\PriceRequest; //バリデーション
use App\Http\Requests\StockCommentRequest; //バリデーション
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Illuminate\Http\ItemRequest;
use Gate;

class ItemStoreController extends Controller
{
  public function seller_edit($id)
  {
    $item = Item::find($id);

    $this->authorize('view', $item); // 権限設定

    $user = Auth::user();
    $stores = Store::where('company_id', $user->company_id)->orderBy('store_name', 'asc')->get();
    return view('items.seller.edit', compact('item', 'user', 'stores'));
  }

  public function seller_update(Request $request, $id)
  {
    $user = Auth::user();
    $item = Item::find($id);

    $this->authorize('update', $item); // 権限設定

    // storeテーブルからidのみ取得
    $store = Store::where('company_id', $user->company_id)->pluck('id');
    // selling_flagの値はstoreid
    $flag = $request->selling_flag;
    // 取得したstoreidはオブジェクトなので、配列に変換する。jsonにして戻す。
    $storeArray = json_decode(json_encode($store), true);
    if (isset($request->selling_flag)) {
      // フォームから取得したselling_flagに値がある場合の処理
      foreach ($request->selling_flag as $flagOn) {
        // 受け取った値からselling_flagを1に変更。表示する設定
        $item->store()->updateExistingPivot($flagOn, ['selling_flag' => 1]);
      }
      // array_diffで受け取っていない値を抽出。storeidを比較して差分を取得
      $flag_diff = array_diff($storeArray, $flag);
      foreach ($flag_diff as $flagOff) {
        // 取得した値は非表示設定なので0に変更
        $item->store()->updateExistingPivot($flagOff, ['selling_flag' => 0]);
      }
    } else {
      // 全部が非表示設定の場合は値が入ってこないので、全店に0を入力する
      foreach ($store as $store) {
        $item->store()->updateExistingPivot($store, ['selling_flag' => 0]);
      }
    }

    return back()->with('success', '取扱店舗の設定を更新しました');
  }

  public function price_edit($id)
  {
    // 価格設定ページ
    $item = Item::find($id);
    $this->authorize('view', $item); // 権限設定

    $user = Auth::user();
    $itemprice = $item->store()->where('item_store.selling_flag', '1')->get();
    if (Gate::allows('admin-higher')) { //管理者権限で全店表示
    } else { // 担当者権限：保持店舗のみ表示
    }
    return view('items.price.edit', compact('item', 'user', 'itemprice'));
  }

  public function price_update(PriceRequest $request, $id)
  {
    $inputs = $request->except('_token', '_method', 'price_update');
    $item = Item::find($id);
    $this->authorize('update', $item); // 権限設定

    // '_token','_method','price_update'以外の値を取得
    for ($i = 0, $num_inputs = count($inputs['store_id']); $i < $num_inputs; $i++) {
      // store_idの数をnum_inputsに代入。その分だけforを回す
      $itemprice = new ItemStore;
      $itemprice = ItemStore::where('item_id', $id)->where('store_id', $inputs['store_id'][$i])->first();
      // store_idのi番目の値を取り出す
      $itemprice->price_type = $inputs['price_type'][$i];
      // price_typeのi番目の値を保存
      $itemprice->price = $inputs['price'][$i];
      $itemprice->value = $inputs['value'][$i];
      if (isset($inputs['start_date'][$i])) {
        $itemprice->start_date = $inputs['start_date'][$i] . ':00';
      } else {
        $itemprice->start_date = $inputs['start_date'][$i];
      }
      if (isset($inputs['end_date'][$i])) {
        $itemprice->end_date = $inputs['end_date'][$i] . ':00';
      } else {
        $itemprice->end_date = $inputs['end_date'][$i];
      }
      $itemprice->save();
    }
    return back()->with('success', '価格設定を更新しました');
  }


  public function stock_edit($id)
  {
    $item = Item::find($id);
    $this->authorize('view', $item); // 権限設定

    $user = Auth::user();
    $itemstock = $item->store()->where('item_store.selling_flag', '1')->get();
    return view('items.stock.edit', compact('item', 'user', 'itemstock'));
  }

  public function stock_update(StockCommentRequest $request, $id)
  {
    $item = Item::find($id);
    $this->authorize('update', $item); // 権限設定

    $inputs = $request->except('_token', '_method', 'stock_update'); // '_token','_method','price_update'以外の値を取得
    for ($i = 0, $num_inputs = count($inputs['store_id']); $i < $num_inputs; $i++) {
      // store_idの数をnum_inputsに代入。その分だけforを回す
      $itemstock = new ItemStore;
      $itemstock = ItemStore::where('item_id', $id)->where('store_id', $inputs['store_id'][$i])->first(); // store_idのi番目の値を取り出す
      $itemstock->stock_set = $inputs['stock_set'][$i];
      $itemstock->stock_amount = $inputs['stock_amount'][$i];
      $itemstock->sort_num = $inputs['sort_num'][$i];
      $itemstock->shelf_number = $inputs['shelf_number'][$i];
      $itemstock->save();
    }
    return back()->with('success', '在庫設定を更新しました');
  }

  public function comment_edit($id)
  {
    $item = Item::find($id);
    $this->authorize('view', $item); // 権限設定

    $user = Auth::user();
    $itemcomment = $item->store()->where('item_store.selling_flag', '1')->get();
    return view('items.comment.edit', compact('item', 'user', 'itemcomment'));
  }

  public function comment_update(StockCommentRequest $request, $id)
  {
    $inputs = $request->except('_token', '_method', 'comment_update');
    $item = Item::find($id);
    $this->authorize('update', $item); // 権限設定

    // '_token','_method','price_update'以外の値を取得
    for ($i = 0, $num_inputs = count($inputs['store_id']); $i < $num_inputs; $i++) {
      // store_idの数をnum_inputsに代入。その分だけforを回す
      $itemcomment = new ItemStore;
      $itemcomment = ItemStore::where('item_id', $id)->where('store_id', $inputs['store_id'][$i])->first(); // store_idのi番目の値を取り出す
      $itemcomment->catch_copy = $inputs['catch_copy'][$i];
      $itemcomment->save();
    }
    return back()->with('success', '店舗コメントを更新しました');
  }



  // public function item_update(ItemRequest $request, $id)
  // {
  //     $item = Item::find($request->id);
  //     $user = Auth::user();
  //     $item->company_id = $user->company_id;
  //     $item->barcode = $request->barcode;
  //     $item->product_code = $request->product_code;
  //     $item->product_name = $request->product_name;
  //     $item->category_id = $request->category_id;
  //     $item->display_flag = $request->display_flag;
  //     $item->original_price = $request->original_price;
  //     $item->description = $request->description;
  //     $item->size = $request->size;
  //     $item->color = $request->color;
  //     $item->tag = $request->tag;
  //     $item->group_code_id = $request->group_code_id;
  //     $item->global_category_id = $request->global_category_id;
  //     $store->item_status = $request->item_status;
  //     $store->industry_id = $request->industry_id;
  //     $store->sku_item_image = $request->sku_item_image;
  //     $item->save();
  //     return redirect()->action('Seller\ItemController@edit', [$item->id]);
  // }
}
