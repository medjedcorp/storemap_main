<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Company extends Model
{

  use Billable;
  
  protected $guarded = ['id'];
  protected $hidden = ['api_token'];

  public $timestamps = true;

    public function user()
    {
    return $this->hasMany('App\Models\User');
    }
    // public function account()
    // {
    // return $this->belongsTo('App\Models\Account');
    // }
    public function store(){
      return $this->hasMany('App\Models\Store');
    }
    public function category(){
      return $this->hasMany('App\Models\Category');
    }
    public function group_code(){
      return $this->hasMany('App\Models\GroupCode');
    }
    public function item(){
      return $this->hasMany('App\Models\Item');
    }
    // public function item_store(){
    //   return $this->hasMany('App\Models\ItemStore');
    // }
    public function item_image(){
      return $this->hasMany('App\Models\ItemImage');
    }
    public function store_image(){
      return $this->hasMany('App\Models\StoreImage');
    }
    public function scopeActiveCompany($query)
    {
      return $query->where('display_flag', '=', '1');
    }
}
