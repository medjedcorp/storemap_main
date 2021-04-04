<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupCode extends Model
{
  // protected $guarded = array('id');
  protected $guarded =  ['id','company_id'];
  
  public static $rules = array(
    'company_id' => 'required',
    'group_code' => 'required',
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
