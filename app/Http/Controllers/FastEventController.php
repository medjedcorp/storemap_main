<?php

namespace App\Http\Controllers;

use App\Models\FastEvent;
use Illuminate\Http\Request;
use App\Http\Requests\FastEventRequest;

class FastEventController extends Controller
{
  public function store(FastEventRequest $request)
  {
    $fastevents = FastEvent::create($request->all());
    return response()->json($fastevents);
    // FastEvent::create($request->all());
    // return response()->json(true);
  }

  public function update(FastEventRequest $request)
  {
    $event = FastEvent::where('id', $request->id)->first();
    $event->fill($request->all());

    $event->save();

    return response()->json(true);
  }

  public function destroy(Request $request)
  {
    FastEvent::where('id', $request->id)->delete();

    return response()->json(true);
  }
}
