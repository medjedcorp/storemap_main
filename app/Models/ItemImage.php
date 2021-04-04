<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; // 追加

class ItemImage extends Model
{
    use Sortable; // 追加

    protected $guarded = array('id');
    // protected $guarded =  ['id', 'company_id']; こっちはエラーになる

    public $timestamps = true;

    public $sortable = ['filename', 'size', 'updated_at']; // 追加

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
