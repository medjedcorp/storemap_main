<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FastEvent extends Model
{
    use SoftDeletes;
    protected $fillable = ['title','start','end','color','store_id'];

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }
}
