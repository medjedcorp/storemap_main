<?php

namespace App\Http\Middleware;

use App\Models\Item;
use Closure;

class CatalogShow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $items = Item::where('id', $request->id)->pluck('global_flag')->first();

      if($items === 0){
          abort(403, '閲覧権限がありません。');
      }
        return $next($request);
    }

}
