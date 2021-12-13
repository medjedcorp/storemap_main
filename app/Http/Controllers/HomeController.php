<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic; // 追加
use App\Models\Company;
use App\Models\Item;
use App\Models\Store;
use App\Models\ItemStore;
use App\Models\ItemImage;
use App\Models\StoreImage;
use Laravel\Cashier\Cashier;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $topics = topic::latest()->get();
        $topics = topic::latest()->paginate(10);
        $features = topic::where('info', 0)->latest()->paginate(10);
        $promotions = topic::where('info', 1)->latest()->paginate(10);
        $maintenances = topic::whereIn('info', [2, 3])->latest()->paginate(10);
        $others = topic::whereIn('info', [4, 5])->latest()->paginate(10);

        $light_id = config('services.stripe.light');
        $basic_id = config('services.stripe.basic');
        $premium_id = config('services.stripe.premium');
        $stores_id = config('services.stripe.stores');
        $user = Auth::user();
        $company = Company::where('id', $user->company_id)->first();
        // $payinfo = $company->subscription('main');

        // 最大店舗数取得
        // 課金にstores_idがある場合、店舗ない場合は項目なしになる
        if ($company->subscribedToPlan($stores_id, 'main')) {
            // stores_idの決済方法をカンパニーでセグメントしてメインから取得
            $subscriptionItem = $company->subscription('main')->findItemOrFail($stores_id);
            // 該当idからquantity(店舗数)を取得
            $stores_quantity = $subscriptionItem->quantity;
            $maxStores = $stores_quantity + 1;
        } else {
            $maxStores = 1;
        }

        $nowItemImages = ItemImage::where('company_id', $user->company_id)->sum('size');
        $nowStoreImages = StoreImage::where('company_id', $user->company_id)->sum('size');
        $nowImages = $nowItemImages + $nowStoreImages;

        // 最大登録可能商品と画像容量取得
        if ($company->subscribedToPlan($light_id, 'main')) {
            $plan = 'ライトプラン';
            $maxItems = config('services.stripe.light_item');
            $maxImages =  config('services.stripe.light_storage'); // 104857600
            $storageTxt =  config('services.stripe.light_storage_domination');
            $nowImagesTxt = round(($nowItemImages + $nowStoreImages) / 1000000, 2);
            $zanTxt = round(($maxImages - $nowImages) / 1000000, 2). ' Mbyte';
        } elseif ($company->subscribedToPlan($basic_id, 'main')) {
            $plan = 'ベーシックプラン';
            $maxItems = config('services.stripe.basic_item');
            $maxImages =  config('services.stripe.basic_storage');
            $storageTxt =  config('services.stripe.basic_storage_domination');
            $nowImagesTxt = round(($nowItemImages + $nowStoreImages) / 1000000000, 2);
            // $zanTxt = $maxImages - $nowImages;
            $zanTxt = round(($maxImages - $nowImages) / 1000000000, 2) . ' Gbyte';
        } elseif ($company->subscribedToPlan($premium_id, 'main')) {
            $plan = 'プレミアムプラン';
            $maxItems = config('services.stripe.premium_item');
            $maxImages =  config('services.stripe.premium_storage');
            $storageTxt =  config('services.stripe.premium_storage_domination');
            $nowImagesTxt = round(($nowItemImages + $nowStoreImages) / 1000000000, 2);
            $zanTxt = round(($maxImages - $nowImages) / 1000000000, 2) . ' Gbyte';
        } else {
            $plan = 'フリープラン';
            $maxItems = config('services.stripe.free_item');
            $maxImages =  config('services.stripe.free_storage'); // 10485760	
            $storageTxt =  config('services.stripe.free_storage_domination');
            $nowImagesTxt = round(($nowItemImages + $nowStoreImages) / 1048576, 2);
            $zanTxt = round(($maxImages - $nowImages) / 1048576, 2) . ' Mbyte';
        }

        if ($company->hasDefaultPaymentMethod()) {
            $trial = $company->subscription('main')->onTrial();
        } else {
            $trial = null;
        }

        if ($trial) {
            // 試用期間中の場合は日付を返す
            $trial_ends = $company->subscription('main')->trial_ends_at;

        } else {
            $trial_ends = '';
        }

        $nowStores = Store::where('company_id', $user->company_id)->count();
        $nowItems = Item::where('company_id', $user->company_id)->count();

        // dd($nowStores,$nowItems,$maxStores,$maxItems );

        $pgsStores = $nowStores / $maxStores * 100;
        $pgsItems = $nowItems / $maxItems * 100;
        $pgsImages = $nowImages / $maxImages * 100;

        $companyName = $company->company_name;

        return view('home', compact('topics', 'features', 'promotions', 'maintenances', 'others', 'plan', 'maxItems', 'maxImages', 'maxStores', 'nowStores', 'nowItems', 'nowImages', 'pgsStores', 'pgsItems', 'pgsImages', 'storageTxt', 'nowImagesTxt', 'zanTxt', 'trial_ends', 'companyName'));
        // return view('home', ['topics' => $topics]);
    }
}
