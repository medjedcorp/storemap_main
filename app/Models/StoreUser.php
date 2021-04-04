<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreUser extends Model
{
    protected $primaryKey = array('store_id','user_id');
}
