<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// API 受信 api.phpはcsrfが無効になるから、外部からアクセスできます
Route::post('/sregi/receive_stock', 'SmaregiReceiveController@stockImport'); // 在庫
Route::post('/sregi/receive_item', 'SmaregiReceiveController@itemImport'); // 価格

// 汎用受信API
Route::post('/common/receive_stock', 'CommonApiReceiveController@stockImport');
Route::post('/common/receive_item', 'CommonApiReceiveController@itemImport');
// Route::post('smapi/receive_item', 'SmApiReceiveController@itemImport');

Route::get('/sample', 'SampleController@apiHello'); //api/sampleのページになる
// Route::get('/sample', [SampleController::class, 'apiHello']); // 8の書き方