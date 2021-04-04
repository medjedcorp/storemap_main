<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; // 追加

class Category extends Model
{
  use Sortable; // 追加

  // protected $guarded = array('id');
  protected $guarded =  ['id','company_id'];

  public $sortable = ['category_code', 'category_name', 'display_flag'];  // 追加

  public static $rules = array(
    'category_code' => 'required',
    'category_name' => 'required',
    'display_flag' => 'required',
  );
  public $timestamps = true;
  public function item()
  {
    return $this->hasMany('App\Models\Item');
  }
  public function company()
    {
    return $this->belongsTo('App\Models\Company');
    }
}
