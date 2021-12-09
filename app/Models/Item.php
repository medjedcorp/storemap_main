<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Kyslik\ColumnSortable\Sortable; // 追加

class Item extends Model
{
  use Sortable; // 追加

  protected $guarded =  ['id'];
  // protected $guarded =  ['id', 'company_id'];

  public $sortable = ['product_code', 'product_name', 'original_price', 'barcode', 'display_flag', 'updated_at']; // 追加

  public $timestamps = true;

  public function color()
  {
    return $this->belongsTo('App\Models\Color');
  }

  //データーベース連携設定
  public function company()
  {
    return $this->belongsTo('App\Models\Company');
  }
  public function category()
  {
    return $this->belongsTo('App\Models\Category');
  }
  public function group_code()
  {
    return $this->belongsTo('App\Models\GroupCode');
  }
  public function storemap_category()
  {
    return $this->belongsTo('App\Models\StoremapCategory');
  }
  public function store()
  {
    return $this->belongsToMany('App\Models\Store', 'item_store', 'item_id', 'store_id')
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
  public function scopeActiveItem($query)
  {
    return $query->where('display_flag', '=', '1');
  }
}
