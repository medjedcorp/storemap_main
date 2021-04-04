<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Store;
// use App\Models\Item;
// use App\Models\ItemStore;
// use App\Models\Category;
// use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic; // 追加
// use Illuminate\Support\Facades\DB;
// use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Pagination\Paginator;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $topics = topic::latest()->get();
        $topics = topic::latest()->paginate(10);
        $features = topic::where('info', 0)->latest()->paginate(10);
        $promotions = topic::where('info', 1)->latest()->paginate(10);
        $maintenances = topic::whereIn('info',[2,3])->latest()->paginate(10);
        $others = topic::whereIn('info',[4,5])->latest()->paginate(10);
        
        return view('home', compact('topics', 'features', 'promotions','maintenances','others'));
        // return view('home', ['topics' => $topics]);
    }

}
