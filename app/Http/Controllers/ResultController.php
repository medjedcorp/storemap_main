<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Company;
use App\Models\Subscription;
use App\Models\Item;
use App\Models\ItemStore;
use App\Models\StoremapCategory;
use App\Models\Prefecture;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;

// https://github.com/lazychaser/laravel-nestedsetを使ってます

class ResultController extends Controller
{

  public function show(Request $request)
  {
    // IDをurlから取得
    // dd($request, $request->lat, $request->lng, $request->id);
    $smid = $request->id;
    $keyword = $request->keyword;
    $lat = $request->lat;
    $lng = $request->lng;
    $req_pref = $request->pref;
    $req_city = $request->city;
    $req_ward = $request->ward;
    $limitStores = config('services.limit_stores');

    //端末判断
    $user_agent = $request->header('User-Agent');
    if ((strpos($user_agent, 'iPhone') !== false)
      || (strpos($user_agent, 'iPod') !== false)
      || (strpos($user_agent, 'Android') !== false)
    ) {
      $terminal = 'sp';
    } else {
      $terminal = 'pc';
    }

    // SMカテ作成
    if ($smid) {
      $smids = StoremapCategory::orWhereDescendantOf($smid)->pluck('id');
      $low_cates = StoremapCategory::where('parent_id', $smid)->get();
      $sm_name =  StoremapCategory::where('id', $smid)->first();
      // 親階層取得
      $psm_cate = StoremapCategory::ancestorsOf($smid)->pluck('id');
      if ($psm_cate->isEmpty()) {
        // 親がない場合
        $psmid = null;
      } else {
        // 親ある場合
        $psmid = $psm_cate['0'];
      }
    } else {
      $low_cates = StoremapCategory::where('parent_id', null)->get();
      $smids = null;
      $sm_name =  null;
      $psmid = null;
    }


    // 都道府県一覧作成
    if ($req_pref) {
      // 都道府県指定がある場合
      $pref = Prefecture::where('region', $req_pref)->get();
      $prefectures = $pref->groupBy('region')->transform(function ($pref) {
        return $pref->groupBy('city');
      });
    } else {
      // 都道府県指定がない場合
      $pref = Prefecture::all();
      $prefectures = $pref->groupBy('region')->transform(function ($pref) {
        return $pref->groupBy('city');
      });
    }

    // 位置情報を拒否した場合、latとlngがない。
    if ($req_pref === null and $lat === null and $lng === null) {
      if ($terminal === 'pc') {
        // pc 端末用
        return view("/result")->with([
          'warning' => '※位置情報の取得に失敗しました。',
          'store_items' => null,
          'low_cates' => $low_cates,
          'sm_name' => $sm_name,
          'psmid' => $psmid,
          'keyword' => null,
          'req_pref' => $req_pref,
          'req_city' => $req_city,
          'req_ward' => $req_ward,
          'req_ward' => $req_ward,
          'lat' => null,
          'lng' => null,
          'prefectures' => $prefectures,
          'smid' => null
        ]);
      } else {
        // sp 端末用
         return view("/sp-result")->with([
          'warning' => '※位置情報の取得に失敗しました。',
          'store_items' => null,
          'low_cates' => $low_cates,
          'sm_name' => $sm_name,
          'psmid' => $psmid,
          'keyword' => null,
          'req_pref' => $req_pref,
          'req_city' => $req_city,
          'req_ward' => $req_ward,
          'req_ward' => $req_ward,
          'lat' => null,
          'lng' => null,
          'prefectures' => $prefectures,
          'smid' => null
        ]);
      }
    }

    if ($req_pref && $req_city && $req_ward) {
      // 区とか郡の区役所位置設定
      $first_place = Prefecture::where('region', $req_pref)->where('city', $req_city)->where('ward', $req_ward)->selectRaw("id,code,region,city,ward,ST_X( location ) As latitude, ST_Y( location ) As longitude ")->first();

      $lat = $first_place->latitude;
      $lng = $first_place->longitude;

      $store_data = Store::where('prefecture', $first_place->region)
        ->where('store_city', 'like', '%' . $first_place->city . '%')
        ->where('store_adnum', 'like', '%' . $first_place->ward . '%')
        ->ActiveStore()
        ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LineString( " . $lat . " " . $lng . " , ' , ST_X( location ),' ', ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
        ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
        ->orderBy('distance', 'ASC') //遠い順、近い順
        ->limit($limitStores)
        ->get();
    } elseif ($req_pref && $req_city && !$req_ward) {
      // 市役所位置設定
      $first_place = Prefecture::where('region', $req_pref)->where('city', $req_city)->selectRaw("id,code,region,city,ward,ST_X( location ) As latitude, ST_Y( location ) As longitude ")->first();

      $lat = $first_place->latitude;
      $lng = $first_place->longitude;

      // 市だけの場合、区や郡を持ってる可能性がある
      if ($first_place->ward) {
        $req_city = $first_place->city;
        $req_ward = $first_place->ward;
        // 県庁所在地に区がある場合
        $store_data = Store::where('prefecture', $first_place->region)
          ->where('store_city', 'like', '%' . $first_place->city . '%')
          ->where('store_adnum', 'like', '%' . $first_place->ward . '%')
          ->ActiveStore()
          ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LineString( " . $lat . " " . $lng . " , ' , ST_X( location ),' ', ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
          ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
          ->orderBy('distance', 'ASC') //遠い順、近い順
          ->limit($limitStores)
          ->get();
      } else {
        $req_city = $first_place->city;
        // 市だけの場合
        $store_data = Store::where('prefecture', $first_place->region)
          ->where('store_city', 'like', '%' . $first_place->city . '%')
          ->ActiveStore()
          ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LineString( " . $lat . " " . $lng . " , ' , ST_X( location ),' ', ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
          ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
          ->orderBy('distance', 'ASC') //遠い順、近い順
          ->limit($limitStores)
          ->get();
      }
    } elseif ($req_pref && !$req_city && !$req_ward) {
      $first_place = Prefecture::where('region', $req_pref)->selectRaw("id,code,region,city,ward,ST_X( location ) As latitude, ST_Y( location ) As longitude ")->first();

      if (empty($first_place->latitude)) {
        if ($terminal === 'pc') {
          return view("/result")->with([
            'warning' => '※位置情報の取得に失敗しました。',
            'store_items' => null,
            'low_cates' => $low_cates,
            'sm_name' => $sm_name,
            'psmid' => $psmid,
            'keyword' => null,
            'req_pref' => $req_pref,
            'req_city' => $req_city,
            'req_ward' => $req_ward,
            'req_ward' => $req_ward,
            'lat' => null,
            'lng' => null,
            'prefectures' => $prefectures,
            'smid' => null
          ]);
        } else {
          return view("/sp-result")->with([
            'warning' => '※位置情報の取得に失敗しました。',
            'store_items' => null,
            'low_cates' => $low_cates,
            'sm_name' => $sm_name,
            'psmid' => $psmid,
            'keyword' => null,
            'req_pref' => $req_pref,
            'req_city' => $req_city,
            'req_ward' => $req_ward,
            'req_ward' => $req_ward,
            'lat' => null,
            'lng' => null,
            'prefectures' => $prefectures,
            'smid' => null
          ]);
        }
      } else {
        $lat = $first_place->latitude;
        $lng = $first_place->longitude;
      }

      // 県だけの場合、市区町村のどれか持ってる
      if ($first_place->ward) {
        $req_city = $first_place->city;
        $req_ward = $first_place->ward;
        // 県庁所在地に区がある場合
        $store_data = Store::where('prefecture', $first_place->region)
          ->where('store_city', 'like', '%' . $first_place->city . '%')
          ->where('store_adnum', 'like', '%' . $first_place->ward . '%')
          ->ActiveStore()
          ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LineString( " . $lat . " " . $lng . " , ' , ST_X( location ),' ', ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
          ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
          ->orderBy('distance', 'ASC') //遠い順、近い順
          ->limit($limitStores)
          ->get();
      } else {
        $req_city = $first_place->city;
        // 市だけの場合
        $store_data = Store::with('company')
          ->with('')
          ->where('prefecture', $first_place->region)
          ->where('store_city', 'like', '%' . $first_place->city . '%')
          ->ActiveStore()
          ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LineString( " . $lat . " " . $lng . " , ' , ST_X( location ),' ', ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
          ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
          ->orderBy('distance', 'ASC') //遠い順、近い順
          ->limit($limitStores)
          ->get();
      }
    } else {
      // 近隣のお店２００件取得
      // 都道府県名が入ってない場合

      // sqlを取得？不要なんだけど、なぜか消すとスマホで位置情報取得のエラーがでる。謎すぎるから残す
      // $sql = Store::ActiveStore()
      //   ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LineString( " . $lat . " " . $lng . " , ' , ST_X( location ),' ', ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
      //   ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
      //   ->orderBy('distance', 'ASC') //遠い順、近い順
      //   ->limit(10)
      //   ->toSql();

      // お店情報を取得
      // $store_data = Store::ActiveStore()
      // ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LineString( {$lat} {$lng} , ' , ST_X( location ),' ', ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
      // ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
      // ->orderBy('distance', 'ASC') //遠い順、近い順
      // ->limit(200)
      // ->get();

      // 自分の位置から、近いお店を２００件取得

      $store_data = Store::ActiveStore()
        ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LineString( " . $lat . " " . $lng . " , ' , ST_X( location ),' ', ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
        ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
        ->orderBy('distance', 'ASC') //遠い順、近い順
        ->limit($limitStores)
        ->get();
    }

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
    $store_items = collect($store_items); // 配列をコレクションに変換

    if ($terminal === 'pc') {
    return view('/result', compact('store_items', 'low_cates', 'keyword', 'smid', 'lat', 'lng', 'sm_name', 'psmid', 'prefectures', 'req_pref', 'req_city', 'req_ward'));
    } else {
      return view('/sp-result', compact('store_items', 'low_cates', 'keyword', 'smid', 'lat', 'lng', 'sm_name', 'psmid', 'prefectures', 'req_pref', 'req_city', 'req_ward'));
    }
  }
}
