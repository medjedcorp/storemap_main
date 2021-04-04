<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    // protected $guarded = array('id');
    protected $guarded = ['id','color_list','color_code'];

    public $timestamps = false;
    public function item()
    {
      return $this->hasMany('App\Models\Item');
    }
}
