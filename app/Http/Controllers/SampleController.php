<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Http;
use Log;
use App\Models\Company;
use App\Models\Store;
use App\Models\Item;
use App\Models\ItemStore;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\DataWorkerErrorMail;

// 汎用受信API
class SampleController extends Controller
{
    public function apiHello(Request $request)
    {
        // return 'Hello World';
        return response()->json(
            [
                'morning' => $request->input('morning'),
                'noon' => $request->input('noon'),
            ]
        );
    }

}
