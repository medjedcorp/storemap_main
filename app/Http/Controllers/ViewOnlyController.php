<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewOnlyController extends Controller
{
    public function category()
    {
      return view('categories.data');
    }

    public function smcate()
    {
      return view('system.smcate');
    }

    public function prefecture()
    {
      return view('system.prefecture');
    }

    public function items()
    {
      return view('items.manage');
    }

    public function stores()
    {
      return view('stores.data');
    }

    public function corporate()
    {
      return view('corporate');
    }
    public function privacy()
    {
      return view('privacy');
    }
    public function publish()
    {
      return view('publish');
    }
    public function pricelist()
    {
      return view('pricelist');
    }
}
