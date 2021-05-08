<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CompanyCheck;
use App\Http\Middleware\CatalogShow;
use App\Http\Middleware\PaymentCheck;
use App\Http\Middleware\StoreCheck;
use App\Http\Middleware\AddStore;
use App\Http\Middleware\AddItem;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  \Cache::store('redis')->put('Laradock', 'Awesome', 100);
  return view('welcome');
});

Route::get('/', 'SiteTopController@index');
Route::get('/corporate', 'ViewOnlyController@corporate');
Route::get('/privacy', 'ViewOnlyController@privacy');
Route::get('/publish', 'ViewOnlyController@publish');
Route::get('/pricelist', 'ViewOnlyController@pricelist');
// Route::get('top', 'SiteTopController@index');


//パスワードリセット
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// お問い合わせフォーム
Route::get('contact', 'ContactController@index')->name('contact.index');
Route::post('contact/confirm', 'ContactController@confirm')->name('contact.confirm');
Route::post('contact/thanks', 'ContactController@send')->name('contact.send');

Route::get('/result', 'ResultController@show');
Route::get('/result/{pref}', 'ResultController@show');

Route::get('ajax/smcate', 'Ajax\AjaxSmcateController@index');
Route::get('ajax/itemlist/{id}/{keyword}', 'Ajax\AjaxItemListController@index');
Route::get('ajax/pref', 'Ajax\AjaxPrefController@index');

Route::get('store/{id}', 'StoreShowController@show')->name('store.show');
Route::get('store/{id}/{cate_id}', 'CateShowController@show')->name('store.cateShow2');

Route::get('item/{sid}/{icode}', 'SkuController@index')->name('item.index');

Route::get('smcate', 'SmCateShowController@show')->name('sm.cateShow');

// stripe
Route::post('stripe/webhook', 'StripeController@handleWebhook');

//カレンダー見せる
Route::get('calendar/{sid}', 'CalendarController@index')->name('calendar.index');
//カレンダーのajax
Route::get('calendar/load-events/{sid}', 'EventController@loadEvents')->name('routeLoadEvents');

// 追記
Route::get('seller-register', 'Auth\RegisterController@showSellerRegistrationForm')->name('seller.register.show');
// 既存のregisterをseller-registerへ
Route::get('user-register', 'Auth\RegisterController@showUserRegistrationForm')->name('user.register.show');

// Auth::routes();
Auth::routes(['verify' => true]);
// Auth::routes(['verify' => true, 'register' => false]);
// Auth::routes([
//   'verify'   => true, // メール確認機能（※5.7系以上のみ）
//   'register' => false, // デフォルトの登録機能OFF
//   'reset'    => true,  // メールリマインダー機能ON
// ]);
// Route::middleware('auth','CompanyCheck')->group(function () {});
Route::middleware('verified')->group(function () {
  Route::middleware('auth')->group(function () {
    // 要ログイン
    Route::resource('company', 'CompanyController', ['onphp artisan config:cachely' => ['create', 'store']]);
    Route::resource('company', 'CompanyController', ['only' => ['edit', 'update', 'show']]);
    Route::get('/company/download', 'CompanyController@download'); //会社証明ダウンロード用

    // stripeのwebhook設定
    Route::post('stripe/webhook', 'WebhookController@handleWebhook');

    Route::middleware('PaymentCheck')->group(function () {

      // 会社情報がなければ、会社登録へ
      // お支払い情報設定
      Route::get('/payment/card', 'SubscriptionController@index')->name('payment.card');
      Route::get('/payment/ajax/status', 'Ajax\SubscriptionController@status');
      Route::post('/payment/ajax/subscribe', 'Ajax\SubscriptionController@subscribe');
      Route::post('/payment/ajax/cancel', 'Ajax\SubscriptionController@cancel');
      Route::post('/payment/ajax/resume', 'Ajax\SubscriptionController@resume');
      Route::post('/payment/ajax/change_plan', 'Ajax\SubscriptionController@change_plan');
      Route::post('/payment/ajax/update_card', 'Ajax\SubscriptionController@update_card');
    });
    Route::middleware('CompanyCheck')->group(function () {

      // ストア一括編集
      // Route::get('/stores/data', function () {
      //   return view('/stores/data');
      // });
      Route::get('/stores/data', 'ViewOnlyController@stores');
      Route::post('/stores/data', 'StoreCsvImportController@importStoreCSV')->name('store.importStoreCSV');
      Route::get('/stores/data/StoreTempFileDownload', 'StoreCsvExportController@StoreTempFileDownload');
      Route::get('/stores/data/download', 'StoreCsvExportController@download');

      // item一括編集
      Route::get('/items/data', 'DataPageController@ItemData')->name('item.data');
      Route::get('/items/data/ItemTempFileDownload', 'ItemCsvExportController@ItemTempFileDownload');
      Route::get('/items/data/SMCTempFileDownload', 'ItemCsvExportController@SMCTempFileDownload');
      Route::get('/items/data/download', 'ItemCsvExportController@download');
      Route::post('/items/data', 'ItemCsvImportController@importItemCSV')->name('item.importItemCSV');

      // 販売管理一括編集
      // Route::get('/items/manage', function () {
      //   return view('/items/manage');
      // });
      Route::get('/items/manage', 'ViewOnlyController@items');
      Route::get('/items/manage/download', 'ItemStoreCsvExportController@download');
      Route::post('/items/manage', 'ItemStoreCsvImportController@importItemStoreCSV')->name('IS.importISCSV');
      Route::get('/items/manage/ItemStoreTempFileDownload', 'ItemStoreCsvExportController@ItemStoreTempFileDownload');

      Route::resource('categories', 'CategoryController', ['except' => 'show']);
      Route::resource('users', 'UserController', ['except' => 'show']);
      Route::resource('stores', 'StoreController', ['only' => ['create', 'store']])->middleware('AddStore');
      Route::resource('stores', 'StoreController', ['except' => ['create', 'store']]);
      Route::resource('items', 'ItemController', ['only' => ['create', 'store']])->middleware('AddItem');
      Route::resource('items', 'ItemController', ['except' => ['create', 'store', 'show']]);

      Route::middleware('StoreCheck')->group(function () {
        Route::get('/items/{id}/seller/edit', 'ItemStoreController@seller_edit')->name('items.seller.edit');
        Route::get('/items/{id}/price', 'ItemStoreController@price_edit')->name('items.price.edit');
        Route::get('/items/{id}/stock', 'ItemStoreController@stock_edit')->name('items.stock.edit');
        Route::get('/items/{id}/comment', 'ItemStoreController@comment_edit')->name('items.comment.edit');
      });
      // 商品取扱店舗
      Route::patch('/items/{id}/seller/edit/update', 'ItemStoreController@seller_update')->name('items.seller.update');

      // 販売価格設定
      Route::patch('/items/{id}/price', 'ItemStoreController@price_update')->name('items.price.update');

      // 在庫設定
      Route::patch('/items/{id}/stock', 'ItemStoreController@stock_update')->name('items.stock.update');

      // コメント設定
      Route::patch('/items/{id}/comment', 'ItemStoreController@comment_update')->name('items.comment.update');

      // インボイス生成
      // Route::get('company/invoice/{id}','SubscriptionController@downloadInvoice');

      // 店舗画像アップロード
      Route::post('/img/store/upload', 'StoreImgController@postUpload');
      Route::get('ajax/storeimg01', 'StoreImgController@ajax01');
      Route::get('ajax/storeimg02', 'StoreImgController@ajax02');
      Route::get('ajax/storeimg03', 'StoreImgController@ajax03');
      Route::get('ajax/storeimg04', 'StoreImgController@ajax04');
      Route::get('ajax/storeimg05', 'StoreImgController@ajax05');

      // ストアマップカテゴリが変更されたときのajax通信用
      Route::get('/smcate_seconde_api', 'SmCateController@getSecondLayer')->name('smcate.getSecondLayer');
      Route::get('/smcate_third_api', 'SmCateController@getThirdLayer')->name('smcate.getThirdLayer');
      Route::get('/smcate_fourth_api', 'SmCateController@getFourthLayer')->name('smcate.getFourthLayer');
      Route::get('/smcate_fifth_api', 'SmCateController@getFifthLayer')->name('smcate.getFifthLayer');
      Route::get('/smcate_sixth_api', 'SmCateController@getSixthLayer')->name('smcate.getSixthLayer');
      Route::get('/smsearch_api', 'SmCateController@smSearch')->name('smcate.getSmSearch');

      // 商品画像アップロード
      Route::post('/img/item/upload', 'ItemImgController@postUpload');
      Route::get('ajax/itemimg01', 'ItemImgController@ajax01');
      Route::get('ajax/itemimg02', 'ItemImgController@ajax02');
      Route::get('ajax/itemimg03', 'ItemImgController@ajax03');
      Route::get('ajax/itemimg04', 'ItemImgController@ajax04');
      Route::get('ajax/itemimg05', 'ItemImgController@ajax05');
      Route::get('ajax/itemimg06', 'ItemImgController@ajax06');
      Route::get('ajax/itemimg07', 'ItemImgController@ajax07');
      Route::get('ajax/itemimg08', 'ItemImgController@ajax08');
      Route::get('ajax/itemimg09', 'ItemImgController@ajax09');
      Route::get('ajax/itemimg10', 'ItemImgController@ajax10');

      // 画像管理
      Route::get('/album/items', 'AlbumItemController@index')->name('album.item.index');
      Route::delete('/album/items/delete', 'AlbumItemController@destroy')->name('album.item.destroy');
      Route::get('/album/stores', 'AlbumStoreController@index')->name('album.store.index');
      Route::delete('/album/stores/delete', 'AlbumStoreController@destroy')->name('album.store.destroy');

      // カタログ
      Route::get('/catalog', 'CatalogController@index')->name('catalog.index');
      Route::get('/catalog/{id}/show', 'CatalogController@show')->middleware('CatalogShow')->name('catalog.show');
      Route::post('/catalog/{id}/show/', 'CatalogController@copy')->name('catalog.copy');
      Route::post('/catalog/data', 'CatalogCsvImportController@importCatalogCSV')->name('catalog.importCSV');
      Route::get('/catalog/data', 'DataPageController@CatalogData')->name('catalog.data');
      Route::get('/catalog/data/CatalogTempFileDownload', 'CatalogController@CatalogTempFileDownload')->name('catalog.download');

      // カレンダー
      Route::put('calendar/event-update/{sid}', 'EventController@update')->name('routeEventUpdate');
      Route::post('calendar/event-store', 'EventController@store')->name('routeEventStore');
      Route::delete('calendar/event-destroy', 'EventController@destroy')->name('routeEventDelete');
      Route::delete('calendar/fast-event-destroy', 'FastEventController@destroy')->name('routeFastEventDelete');
      Route::put('calendar/fast-event-update', 'FastEventController@update')->name('routeFastEventUpdate');
      Route::post('calendar/fast-event-store', 'FastEventController@store')->name('routeFastEventStore');

      //カテゴリ一括編集
      // Route::get('/categories/data', function () {
      //   return view('/categories/data');
      // });
      Route::get('/categories/data', 'ViewOnlyController@category');
      Route::post('/categories/data', 'CategoryCsvImportController@importCateCSV')->name('cate.importCateCSV');
      Route::get('/categories/data/CateTempFileDownload', 'CategoryCsvExportController@CateTempFileDownload');
      Route::get('/categories/data/download', 'CategoryCsvExportController@download');

      // パスワード変更
      Route::get('changepassword', 'PasswordController@showChangePasswordForm');
      Route::post('changepassword', 'PasswordController@changePassword')->name('changepassword');

      // トピックスの作成
      // Route::resource('home', 'TopicsController', ['only' => ['index']]);
      Route::get('/home', 'HomeController@index')->name('home');
      // Route::get('/home', 'TopicsController@index')->name('topics.index');
      Route::get('/topics/create', 'TopicsController@create')->name('topics.create');
      Route::post('/topics/', 'TopicsController@store')->name('topics.store');
      Route::get('/topics/{id}', 'TopicsController@show')->name('topics.show');
      Route::get('/topics/{id}/edit', 'TopicsController@edit')->name('topics.edit');
      Route::put('/topics/{id}', 'TopicsController@update')->name('topics.update');
      Route::delete('/topics/{id}', 'TopicsController@destroy')->name('topics.destroy');

      // スマレジAPI
      Route::get('/config/sr-import', 'SmaregiController@show')->name('sr.product_ref');
      Route::post('/config/sr-import/store', 'SmaregiController@store')->name('sr.tokensave');
      Route::post('/config/sr-import/stores_id', 'SmaregiController@storesId')->name('sr.storeSave');
      Route::post('/config/sr-import/data', 'SmarejiCsvImportController@importCSV')->name('sr.importCSV');
      Route::get('/config/sr-import/stfdownload', 'SmaregiController@SmarejiTempFileDownload');
      // Route::post('/config/sr-import/update', 'SmaregiController@update')->name('sr.product_update');

      // システム アドミンのみ
      Route::group(['middleware' => ['auth', 'can:isAdmin']], function () {
        // Route::get('/system/data', function () {
        //   return view('/system/smcate');
        // });
        Route::get('/system/smcate', 'ViewOnlyController@smcate');
        // ストアマップカテゴリ登録用
        Route::post('/system/smcate', 'SmCateCsvImportController@importSmCateCSV')->name('system.importSmCateCSV');
        Route::get('/system/smcate/download', 'SmCategoryCsvExportController@download');

        // 都道府県市区町村緯度経度登録用
        // Route::get('/system/prefecture', function () {
        //   return view('/system/prefecture');
        // });
        Route::get('/system/prefecture', 'ViewOnlyController@prefecture');
        Route::post('/system/prefecture', 'PrefectureCsvImportController@importPrefectureCSV')->name('system.importPrefCsv');
        Route::get('/system/prefecture/download', 'prefectureCsvExportController@download');
      });
    });
  });
});
