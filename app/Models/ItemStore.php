<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;

class ItemStore extends Pivot
{
    protected $table = 'item_store';
    // protected $casts = [
    //     'start_date' => 'datetime:Y-m-d H:i',
    //     'end_date' => 'datetime:Y-m-d H:i',
    // ];
    protected $dates = ['start_date', 'end_date'];

    public $timestamps = true;

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
        // return $this->belongsTo(Item::class);
    }
    public function store()
    {
        return $this->belongsTo('App\Models\Store');
        // return $this->belongsTo(Store::class);
    }
    public function scopeActiveStock($query)
    {
        // return $query->where('stock_amount', '>', 0);
        // 在庫が1以上または、在庫設定をしない商品
        return $query->where('stock_amount', '>', 0)->orWhere('stock_set', '=', 0);
    }
    public function scopeItemSort($query)
    {
        // nullを最後にしてから、もっかいソートする
        return $query->where('selling_flag', '=', '1')->orderByRaw('sort_num IS NULL ASC')->orderBy('sort_num', 'ASC');
        // return $query->where('selling_flag', '=', '1')->where('stock_amount', '>', 0)->orderByRaw('sort_num IS NULL ASC')->orderBy('sort_num','ASC');
    }
    public function scopeAllItemSort($query)
    {
        return $query->where('selling_flag', '=', '1')->orderByRaw('sort_num IS NULL ASC')->orderBy('sort_num', 'ASC');
    }

    // public function getUpdatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->format("Y/m/d H:i");
    // }
    // public function company(){
    //     return $this->belongsTo('App\Models\Company');
    // }
    // 店舗表示設定。ディスプレイフラグが０は表示するor在庫が0の場は非表示
    // 検索からも消えちゃうからダメ！
    // protected static function boot(){
    // parent::boot();
    // static::addGlobalScope('dealer_display_flag', function (Builder $builder){
    // $builder->where('dealer_display_flag', '===', 0);
    // $builder->orWhere('stock_amount', '!=', 0);
    // });
    // }
}
