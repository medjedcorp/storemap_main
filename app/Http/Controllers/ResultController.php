<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use App\Models\StoremapCategory;
use App\Models\Prefecture;
use Carbon\Carbon;
use DB;

// https://github.com/lazychaser/laravel-nestedsetを使ってます

class ResultController extends Controller
{

  public function show(Request $request)
  {
    // IDをurlから取得
    // dd($request);
    $smid = $request->id;
    $keyword = $request->keyword;
    $lat = $request->lat;
    $lng = $request->lng;
    $req_pref = $request->pref;
    $req_city = $request->city;
    $req_ward = $request->ward;

    // 位置情報を拒否した場合、latとlngがない。
    if ($req_pref === "" and $lat === "" and $lng === "") {
      // var_dump($req_pref, $lat, $lng);
      return redirect("/result")->with([
        'warning' => '※位置情報の取得に失敗しました。',
      ]);
    }
    // if (empty($req_pref) and empty($lat) and empty($lng)) {
    //   var_dump($req_pref, $lat, $lng);
    //   return redirect("/result")->with([
    //     'warning' => '※位置情報の取得に失敗しました。error_015',
    //   ]);
    // }
    // dd($req_pref);

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

    if ($req_pref && $req_city && $req_ward) {
      // 区とか郡の区役所位置設定
      $first_place = Prefecture::where('region', $req_pref)->where('city', $req_city)->where('ward', $req_ward)->selectRaw("id,code,region,city,ward,ST_X( location ) As latitude, ST_Y( location ) As longitude ")->first();

      $lat = $first_place->latitude;
      $lng = $first_place->longitude;

      $store_data = Store::where('prefecture', $first_place->region)
        ->where('store_city', 'like', '%' . $first_place->city . '%')
        ->where('store_adnum', 'like', '%' . $first_place->ward . '%')
        ->ActiveStore()
        ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( {$lat} {$lng} , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
        ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
        ->orderBy('distance', 'ASC') //遠い順、近い順
        ->limit(200)
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
          ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( {$lat} {$lng} , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
          ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
          ->orderBy('distance', 'ASC') //遠い順、近い順
          ->limit(200)
          ->get();
      } else {
        $req_city = $first_place->city;
        // 市だけの場合
        $store_data = Store::where('prefecture', $first_place->region)
          ->where('store_city', 'like', '%' . $first_place->city . '%')
          ->ActiveStore()
          ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( {$lat} {$lng} , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
          ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
          ->orderBy('distance', 'ASC') //遠い順、近い順
          ->limit(200)
          ->get();
      }
    } elseif ($req_pref && !$req_city && !$req_ward) {
      $first_place = Prefecture::where('region', $req_pref)->selectRaw("id,code,region,city,ward,ST_X( location ) As latitude, ST_Y( location ) As longitude ")->first();

      if (empty($first_place->latitude)) {
        return redirect("/result")->with([
          'warning' => '※位置情報の取得に失敗しました。',
        ]);
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
          ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( {$lat} {$lng} , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
          ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
          ->orderBy('distance', 'ASC') //遠い順、近い順
          ->limit(200)
          ->get();
      } else {
        $req_city = $first_place->city;
        // 市だけの場合
        $store_data = Store::where('prefecture', $first_place->region)
        ->where('store_city', 'like', '%' . $first_place->city . '%')
        ->ActiveStore()
        ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( {$lat} {$lng} , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
        ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
        ->orderBy('distance', 'ASC') //遠い順、近い順
        ->limit(200)
        ->get();
        // $store_data = Store::where('prefecture', $first_place->region)
        //   ->where('store_city', 'like', '%' . $first_place->city . '%')
        //   ->ActiveStore()
        //   ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LineString( " . $lat . " " . $lng . " , ', ST_X( location ) ,  ' ', ST_Y( location ) ,  ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
        //   ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
        //   ->orderBy('distance', 'ASC') //遠い順、近い順
        //   ->limit(200)
        //   ->get();
      }
    } else {
      // 近隣のお店２００件取得

      $sql = Store::ActiveStore()
      ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LINESTRING(',{$lat},' ',{$lng}, ',' , ST_X( location ),' ',ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
      ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
      ->orderBy('distance', 'ASC') //遠い順、近い順
      ->limit(200)
      ->toSql();

      dd($sql);
      // $store_data = Store::ActiveStore()
      // ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LINESTRING(',{$lat},' ',{$lng}, ',' , ST_X( location ),' ',ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
      // ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
      // ->orderBy('distance', 'ASC') //遠い順、近い順
      // ->limit(200)
      // ->get();
      
      // $store_data = Store::ActiveStore()
      // ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT('LINESTRING(',{$lat},' ',{$lng}, ',' , ST_X( location ),' ',ST_Y( location ),')'))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
      // ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
      // ->orderBy('distance', 'ASC') //遠い順、近い順
      // ->limit(200)
      // ->get();

      // $store_data = Store::ActiveStore()
      //   ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LINESTRING( {$lat} {$lng} , ', ST_X( location ) ,  ' ', ST_Y( location ) , ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
      //   ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
      //   ->orderBy('distance', 'ASC') //遠い順、近い順
      //   ->limit(200)
      //   ->get();


      // $store_data = Store::ActiveStore()
      //   ->selectRaw("id,store_name,store_img1,store_postcode,prefecture,store_city,store_adnum,store_apart,store_phone_number,store_email,store_info,ST_X( location ) As latitude, ST_Y( location ) As longitude, ROUND(ST_LENGTH(ST_GEOMFROMTEXT( CONCAT( 'LINESTRING( " . $lat . " " . $lng . " , ', ST_X( location ) ,  ' ', ST_Y( location ) , ')' ))) * 112.12 * 1000 ) AS distance") // 距離を計測。distanceに距離を代入
      //   ->orderByRaw('distance IS NULL ASC') // Nullは最後尾に
      //   ->orderBy('distance', 'ASC') //遠い順、近い順
      //   ->limit(200)
      //   ->get();

      // dd($store_data , $lat ,$lng);
    }

    if ($smid && $keyword) {
      $store_items = keyCateItemSet($store_data, $keyword, $smids);
    } elseif (!$smid && $keyword) {
      $store_items = keywordItemSet($store_data, $keyword);
    } elseif ($smid && !$keyword) {
      $store_items = smCateItemSet($store_data, $smids);
    } else {
      $store_items = itemSet($store_data);
    }

    $store_items = collect($store_items); // 配列をコレクションに変換

    return view('result', compact('store_items', 'low_cates', 'keyword', 'smid', 'lat', 'lng', 'sm_name', 'psmid', 'prefectures', 'req_pref', 'req_city', 'req_ward'));
  }
}
