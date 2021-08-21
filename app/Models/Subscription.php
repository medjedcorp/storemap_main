<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    protected $guarded = array('id');

    public function scopeActiveSubsc($query)
    {
      $today=Carbon::today();
      return $query->whereDate('ends_at', '>=', $today)->orWhere('ends_at', '=', null);
    }

}
