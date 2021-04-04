<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
  // protected $guarded = array('id');
  protected $guarded = ['id','industry_name'];

  public static $rules = array(
    'industry_name' => 'required'
  );

  public $timestamps = false;
  
  public function store()
  {
    return $this->hasMany('App\Models\Store');
  }
}
