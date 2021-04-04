<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Store;

class EventController extends Controller
{
  public function loadEvents(Request $request, $sid)
  {
    // $events = Event::where('store_id', $sid)->get();
    // 全部取得すると重いから注意。

    // return response()->json($events);
    $store = Store::find($sid);
    $this->authorize('view', $store);

    $returnedColumns = ['id', 'title', 'start', 'end', 'color', 'description', 'store_id'];

    $start = (!empty($request->start)) ? ($request->start) : ('');
    $end = (!empty($request->end)) ? ($request->end) : ('');

    $events = Event::where('store_id', $sid)->whereBetween('start', [$start, $end])->get($returnedColumns);

    return response()->json($events);
  }

  public function store(EventRequest $request)
  {
    Event::create($request->all());
    return response()->json(true);
  }

  public function update(EventRequest $request, $sid)
  {
    $store = Store::find($sid);
    $this->authorize('update', $store);

    $event = Event::where('id', $request->id)->first();
    $event->fill($request->all());

    $event->save();

    return response()->json(true);
  }

  public function destroy(Request $request)
  {

    Event::where('id', $request->id)->delete();

    return response()->json(true);
  }
}
