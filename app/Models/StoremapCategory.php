<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class StoremapCategory extends Model
{
  use NodeTrait;

  protected $guarded = [
    'id',
    'created_at',
    'updated_at',
    'depth',
  ];
  public $timestamps = true;
  public function item()
  {
    return $this->hasMany('App\Models\Item');
  }
}
