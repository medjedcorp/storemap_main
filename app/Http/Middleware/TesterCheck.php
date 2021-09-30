<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class TesterCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // テスターの場合は、表示させない。
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $userRole = $user->role;

        if ($userRole === 'tester') {
            abort(404);
        }
        return $next($request);
    }
}
