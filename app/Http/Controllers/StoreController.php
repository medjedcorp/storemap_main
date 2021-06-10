<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use App\Models\StoreImage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest; //バリデーション
use Illuminate\Support\Facades\DB;
use App\Models\Industry;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use Session;
use Gate;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;

class StoreController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $cid = $user->company_id;
        $c_name = Company::where('id', $cid)->pluck('company_name')->first();

        // 検索からキーワード取得
        $keyword = $request->input('keyword');

        if (isset($keyword)) {
            // カンパニーIDでセグメントしてから、orWhereのいずれかにあてはまったものを抽出
            $stores = Store::select(['id','store_code', 'store_name', 'store_phone_number', 'pause_flag'])->where('company_id', $cid)->where(function($query) use ($keyword){
              $query->orWhere('store_code', 'like', '%'.$keyword.'%')
                    ->orWhere('store_name', 'like', '%'.$keyword.'%');
            })->sortable()->paginate(20);
        } else {
            $stores = Store::select(['id','store_code', 'store_name', 'store_phone_number', 'pause_flag'])->where('company_id', $cid)->sortable()->paginate(20); // ページ作成
        }
        $count = Store::where('company_id', $cid)->get()->count();
        return view('stores.index', [
            'stores' => $stores,
            'keyword' => $keyword,
            'count' => $count,
            'c_name' => $c_name,
        ]);
    }

    public function create()
    {
      $user = Auth::user();
      $company_id = $user->company_id;
      $industry = Industry::orderBy('id')->get();
      // $storeimg = StoreImage::where('company_id', $company_id)->pluck('filename','id');
      // dd($storeimg);
      return view('stores.create', compact( 'user', 'industry', 'company_id'));
      // return view('stores.create', compact( 'user', 'industry', 'company_id', 'storeimg'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $store = new Store;
        $user = Auth::user();
        $store->company_id = $user->company_id;
        $store->store_code = $request->store_code;
        $store->store_name = $request->store_name;
        $store->store_kana = $request->store_kana;
        $store->store_postcode = $request->store_postcode;
        $store->prefecture = $request->prefecture;
        $store->store_city = $request->store_city;
        $store->store_adnum = $request->store_adnum;
        $store->store_apart = $request->store_apart;
        $store->store_phone_number = $request->store_phone_number;
        $store->store_fax_number = $request->store_fax_number;
        $store->store_email = $request->store_email;
        $store->pause_flag = $request->pause_flag;
        $store->store_img1 = $request->store_img1;
        $store->store_img2 = $request->store_img2;
        $store->store_img3 = $request->store_img3;
        $store->store_img4 = $request->store_img4;
        $store->store_img5 = $request->store_img5;
        $store->store_info = $request->store_info;
        $store->industry_id = $request->industry_id;
        $store->store_url = $request->store_url;
        $store->flyer_img = $request->flyer_img;
        $store->floor_guide = $request->floor_guide;
        $store->pay_info = $request->pay_info;
        $store->access = $request->access;
        $store->opening_hour = $request->opening_hour;
        $store->closed_day = $request->closed_day;
        $store->parking = $request->parking;

        //住所を入れて緯度経度を求める。
        // $address = $store->prefecture.$store->store_city.$store->store_adnum.$store->store_apart;
        $address = $store->prefecture.$store->store_city.$store->store_adnum; // アパートは除外
        $myKey = config('const.geo_key');
        // $myKey = env('GOOGLE_MAPS_API_KEY');
        $address = urlencode($address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "+CA&key=" . $myKey ;
        $contents = file_get_contents($url);
        $jsonData = json_decode($contents,true);

        if(is_null($jsonData)){
          $lat = 0;
          $lng = 0;
        } else {
          $lat = $jsonData["results"][0]["geometry"]["location"]["lat"];
          $lng = $jsonData["results"][0]["geometry"]["location"]["lng"];
        }

        $store->location = DB::raw("ST_GeomFromText('POINT(".$lat." ".$lng.")')");

        $store->save();

        //$last_insert_id で最後に入力したIDを取得
        // 取得したIDを使って、中間テーブルでITEMと紐付け
        $last_insert_id = $store->id;
        $last_id = Store::find($last_insert_id);
        $item = Item::where('company_id', $store->company_id)->pluck('id');
        // attach だとstore_idとitem_idが逆につくからダメ…
        for($v = 0 , $size = count($item); $v < $size; $v++){
          $item_store = new ItemStore;
          $item_store->item_id = $item[$v];
          $item_store->store_id = $last_id->id;
          $item_store->save();
        }

        $datum = [
          ['title' => 'Open', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#007bff', 'store_id' => $last_insert_id],
          ['title' => 'Reserved', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#ffc107', 'store_id' => $last_insert_id],
          ['title' => 'Event', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#28a745', 'store_id' => $last_insert_id],
          ['title' => 'Closed', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#dc3545', 'store_id' => $last_insert_id],
          ['title' => 'Information', 'start' => '00:00:00', 'end' => '23:59:59', 'color' => '#6c757d', 'store_id' => $last_insert_id]
        ];
        DB::table('fast_events')-> insert($datum);
        // Session::flash('success', '※登録しました');
        // return redirect()->action('StoreController@show', [$store->id]);
        return redirect("/stores")->with([
          // 'store' => $last_id,
          'success' => '※'. $store->store_name .' を登録しました',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        $company_id = $user->company_id;
        $c_name = Company::where('id', $company_id)->pluck('company_name')->first();
        $store = Store::find($id);
        $this->authorize('view', $store);
        // dd($store);
        $lat = Store::where('id', $id)->selectRaw("ST_X( location ) As latitude")->first();
        $lng = Store::where('id', $id)->selectRaw("ST_Y( location ) As longitude")->first();

        // dd($store,$lat, $lng);

        $img_list = [];

        if($store->store_img1){
          $img_list[] = $store->store_img1;
        }
        if($store->store_img2){
          $img_list[] = $store->store_img2;
        }
        if($store->store_img3){
          $img_list[] = $store->store_img3;
        }
        if($store->store_img4){
          $img_list[] = $store->store_img4;
        }
        if($store->store_img5){
          $img_list[] = $store->store_img5;
        }

        return view('stores.show', compact('store','c_name','company_id','img_list', 'lat', 'lng'));
        // return view('stores.show', ['store' => $store]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $user = Auth::user();
      $company_id = $user->company_id;
      $industry = Industry::orderBy('id')->get();
      $store = Store::find($id);
      $lat = Store::where('id', $id)->selectRaw("ST_X( location ) As latitude")->first();
      $lng = Store::where('id', $id)->selectRaw("ST_Y( location ) As longitude")->first();
      $lat = $lat['latitude'];
      $lng = $lng['longitude'];

      $this->authorize('view', $store);

      $c_name = Company::where('id', $company_id)->pluck('company_name')->first();
      return view('stores.edit', compact( 'user', 'industry', 'company_id', 'store','c_name','lat','lng'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        $store = Store::find($id);

        $this->authorize('update', $store);

        $lat = $store->selectRaw("ST_X( location ) As latitude")->first();
        $lng = $store->selectRaw("ST_Y( location ) As longitude")->first();
        $lat = strval($lat['latitude']);
        $lng = strval($lng['longitude']);

        $new_lat = $request->latitude;
        $new_lng = $request->longitude;

        // dd($request->latitude, $request->longitude, $new_lat, $new_lng, $lat, $lng, "test0");

        if($store->store_postcode !== $request->store_postcode or $store->prefecture !== $request->prefecture or $store->store_city !== $request->store_city or $store->store_adnum !== $request->store_adnum){
          // 住所が違う場合は、先に再度ジオコーディング
          // $address = $store->prefecture.$store->store_city.$store->store_adnum.$store->store_apart;
          $address = $request->prefecture.$request->store_city.$request->store_adnum; //アパートは除外
          $myKey = config('const.geo_key');
          $address = urlencode($address);
          $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "+CA&key=" . $myKey ;
          $contents= file_get_contents($url);
          $jsonData = json_decode($contents,true);
          $lat = $jsonData["results"][0]["geometry"]["location"]["lat"];
          $lng = $jsonData["results"][0]["geometry"]["location"]["lng"];
          $store->location = DB::raw("ST_GeomFromText('POINT(".$lat." ".$lng.")')");
        } elseif( $new_lat and $new_lng ) {
          $lat = $new_lat;
          $lng = $new_lng;
          $store->location = DB::raw("ST_GeomFromText('POINT(".$lat." ".$lng.")')");
        } elseif( $new_lat and !$new_lng ){
          $lat = $new_lat;
          $store->location = DB::raw("ST_GeomFromText('POINT(".$lat." ".$lng.")')");
        } elseif( !$new_lat and $new_lng ){
          $lng = $new_lng;
          $store->location = DB::raw("ST_GeomFromText('POINT(".$lat." ".$lng.")')");
        }

        $user = Auth::user();
        $store->company_id = $user->company_id;
        $store->store_code = $request->store_code;
        $store->store_name = $request->store_name;
        $store->store_kana = $request->store_kana;
        $store->store_postcode = $request->store_postcode;
        $store->prefecture = $request->prefecture;
        $store->store_city = $request->store_city;
        $store->store_adnum = $request->store_adnum;
        $store->store_apart = $request->store_apart;
        $store->store_phone_number = $request->store_phone_number;
        $store->store_fax_number = $request->store_fax_number;
        $store->store_email = $request->store_email;
        $store->pause_flag = $request->pause_flag;
        $store->store_img1 = $request->store_img1;
        $store->store_img2 = $request->store_img2;
        $store->store_img3 = $request->store_img3;
        $store->store_img4 = $request->store_img4;
        $store->store_img5 = $request->store_img5;
        $store->store_info = $request->store_info;
        $store->industry_id = $request->industry_id;
        $store->store_url = $request->store_url;
        $store->flyer_img = $request->flyer_img;
        $store->floor_guide = $request->floor_guide;
        $store->pay_info = $request->pay_info;
        $store->access = $request->access;
        $store->opening_hour = $request->opening_hour;
        $store->closed_day = $request->closed_day;
        $store->parking = $request->parking;
        
        $store->save();

        Session::flash('success', '※更新しました');
        return redirect()->route('stores.show', [$store->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Store::find($id);
        Gate::authorize('isSeller'); // gate staffは削除不可
        $this->authorize('delete', $store);
        $store->delete();
        return redirect("/stores")->with([
          // 'store' => $last_id,
          'danger' => '※'. $store->store_name .' を削除しました',
        ]);
    }

}
