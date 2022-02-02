<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
// use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\StoremapCategory;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AjaxSmcateController extends Controller
{
  public function index(Request $request)
  {
    // キーワードと現在地とSMカテゴリを取得
    // $keyword = $request->input('keyword');
    // $lat =  $request->input('lat');
    // $lng =  $request->input('lng');
    // $smid = $request->input('smid');
    $smid = $request->id;
    $keyword = $request->keyword;
    $lat = $request->lat;
    $lng = $request->lng;
    // $req_pref = $request->pref;
    // $req_city = $request->city;
    // $req_ward = $request->ward;
    // dd($request);


    if (!$lat or !$lng) {
      return response()->json([
        'message' => '位置情報の取得に失敗しました',
      ], 404);
    }

    if (isset($smid)) {
      $smids = StoremapCategory::orWhereDescendantOf($smid)->pluck('id');
      // $low_cates = StoremapCategory::where('parent_id', $smid)->get();
    } else {
      $smids = StoremapCategory::pluck('id');
      // $low_cates = StoremapCategory::where('parent_id', null)->get();
      // Log::debug($smid);
    }
    // dd($smid,$smids);
    // 近くのお店200件を取得
    $limitStores = config('services.limit_stores');

    $store_data = Store::ActiveStore()
      ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LineString( " . $lat . " " . $lng . " , ' , ST_X( location ),' ', ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
      ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
      ->orderBy('distance', 'ASC') //遠い順、近い順
      ->limit($limitStores)
      ->get();

    // $json = json_encode($store_data, JSON_PRETTY_PRINT);
    // Log::debug($json);

    if ($smid && $keyword) {
      $store_items = keyCateItemSet($store_data, $keyword, $smids);
    } elseif (!$smid && $keyword) {
      $store_items = keywordItemSet($store_data, $keyword);
      // dd($store_items, $store_data, $keyword);
      // dd($store_items);
    } elseif ($smid && !$keyword) {
      $store_items = smCateItemSet($store_data, $smids);
    } else {
      $store_items = itemSet($store_data);
      // Log::debug($store_items);
    }

    // Log::debug($store_items);
    $store_items = json_encode($store_items, JSON_UNESCAPED_UNICODE); // 日本語化
    // dd($store_items);
    return $store_items;
  }
}
