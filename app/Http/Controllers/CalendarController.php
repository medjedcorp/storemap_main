<?php

namespace App\Http\Controllers;

use App\Models\FastEvent;
use App\Models\Store;
use Illuminate\Http\Request;
use Redirect, Response;

class CalendarController extends Controller
{
  public function index(Request $request, $sid)
  {
    $fastEvents = FastEvent::where('store_id', $sid)->get();

    $s_name = Store::where('id', $sid)->pluck('store_name')->first();

    $store = Store::find($sid);
    $this->authorize('view', $store);

    return view('calendar.master', compact('sid', 's_name', 'fastEvents'));
  }
}
