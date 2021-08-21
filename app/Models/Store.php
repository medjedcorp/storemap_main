<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
// use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Kyslik\ColumnSortable\Sortable; // 追加
use Laravel\Cashier\Cashier;
use App\Models\Company;
use App\Models\Subscription;

class Store extends Model
{
    use Sortable; // 追加

    public $sortable = ['store_code', 'store_name', 'store_phone_number', 'pause_flag']; // 追加

    // protected $guarded = array('id','company_id');
    protected $guarded = [
        'id',
        'company_id'
      ];
    // protected $fillable = [
    //     'store_code',
    //     'store_name',
    //     'store_kana',
    //     'store_postcode',
    //     'prefecture',
    //     'store_city',
    //     'store_adnum',
    //     'store_apart',
    //     'store_phone_number',
    //     'store_fax_number',
    //     'store_email',
    //     'pause_flag',
    //     'store_img1',
    //     'store_img2',
    //     'store_img3',
    //     'store_img4',
    //     'store_img5',
    //     'store_info',
    //     'industry_id',
    //     'store_url',
    //     'flyer_img',
    //     'floor_guide',
    //     'location',
    // ];

    public $timestamps = true;

    public function industry()
    {
        return $this->belongsTo('App\Models\Industry', 'industry_id');
    }

    public function item()
    {
        return $this->belongsToMany('App\Models\Item', 'item_store', 'item_id', 'store_id')
            ->using('App\Models\ItemStore')
            ->withPivot([
                'catch_copy',
                'shelf_number',
                'price_type',
                'price',
                'value',
                'start_date',
                'end_date',
                'sort_num',
                'selling_flag',
                'stock_amount',
                'stock_set'
            ]);
    }

    public function item_store()
    {
        return $this->hasMany('App\Models\ItemStore');
    }

    public function user()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function company()
    {
        return $this->belongsToMany('App\Models\Company');
    }

    public function event()
    {
        return $this->hasMany('App\Models\Event');
    }

    public function fast_event()
    {
        return $this->hasMany('App\Models\FastEvent');
    }

    //住所をつなげてマルチソートに、Sortableで使用
    public function AddressSortable($query, $direction)
    {
        return $query->orderBy('prefecture', $direction)->orderBy('store_city', $direction)->orderBy('store_adnum', $direction)->orderBy('store_apart', $direction);
    }

    public function scopeActiveStore($query)
    {
    
        // stripeのstatusがactiveか、trialingの場合取得
        $status = ['active', 'trialing'];
        $subscriptions = Subscription::whereIn('stripe_status', $status)->pluck('company_id');
        // 公開状態の会社ID
        $display_company = Company::where('display_flag', 1)->pluck('id');
        // dd($subscriptions);
        return $query->whereIn('stores.company_id', $subscriptions)
        ->whereIn('stores.company_id', $display_company)
        ->where('stores.pause_flag', '=', '1');
        // return $query->where('stores.pause_flag', '=', '1');
        // return $query->whereIn('stores.company_id', $clist)->where('stores.pause_flag', '=', '1');
        // dd($query);
        // $company = Company::get();
        // $company = Company::all();
        // $company = Company::where('id', 1)->first();
        // dd($company);
        // $subscriptions = $company->subscription('main')->first();
        // $subscriptions = $company->subscription('main')->get();
        // dd($subscriptions);
        // return $query->whereIn('stores.company_id', $subscriptions->company_id)->where('stores.pause_flag', '=', '1');
    }

    // 店舗表示設定。ディスプレイフラグが０は表示するor在庫が0の場は非表示
    // // 検索からも消えちゃうからダメ！
    // protected static function boot(){
    //     parent::boot();
    //     static::addGlobalScope('dealer_display_flag', function (Builder $builder){
    //     $builder->where('dealer_display_flag', '===', 0);
    //     $builder->orWhere('stock_amount', '!=', 0);
    //     });
    // }

    
}
