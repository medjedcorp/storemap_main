<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAcceptController extends Controller
{
    public function index()
    {
        return view('system.accept');
    }
}
