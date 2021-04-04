@extends('adminlte::store-page')

@section('title', $item->product_name . '[Storemap]')
{{-- @section('title', 'Dashboard') --}}

{{-- @section('content_header')
<h1>{{$item->product_name}}</h1>
@stop --}}

@section('content')
<section class="content">
  <div class="card card-solid">
    <div class="card-body">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3 class="d-inline-block d-sm-none h4">{{$item->product_name}}</h3>
          <div class="col-12">
            @if($item->item_img1)
            <img src="/storage/{{$item->company_id}}/items/{{$item->item_img1}}" class="product-image" alt="{{$item->product_name}}">
            @else
            <img src="{{ asset('img/no_image.png') }}" class="product-image" alt="{{$item->product_name}}">
            @endif
          </div>
          <div class="col-12 product-image-thumbs flex-wrap">
            @if($item->item_img1)
            <div class="product-image-thumb active"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img1}}" alt="{{$item->product_name}}"></div>
            @else
            <div class="product-image-thumb active"><img src="{{ asset('img/no_image.png') }}" alt="{{$item->product_name}}"></div>
            @endif
            @if($item->item_img2)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img2}}" alt="{{$item->product_name}}"></div>
            @endif
            @if($item->item_img3)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img3}}" alt="{{$item->product_name}}"></div>
            @endif
            @if($item->item_img4)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img4}}" alt="{{$item->product_name}}"></div>
            @endif
            @if($item->item_img5)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img5}}" alt="{{$item->product_name}}"></div>
            @endif
            @if($item->item_img6)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img6}}" alt="{{$item->product_name}}"></div>
            @endif
            @if($item->item_img7)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img7}}" alt="{{$item->product_name}}"></div>
            @endif
            @if($item->item_img8)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img8}}" alt="{{$item->product_name}}"></div>
            @endif
            @if($item->item_img9)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img9}}" alt="{{$item->product_name}}"></div>
            @endif
            @if($item->item_img10)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img10}}" alt="{{$item->product_name}}"></div>
            @endif
            {{-- @for( $i = 2; $i < 11; $i++)
            @if($item->item_img.$i)
            <div class="product-image-thumb"><img src="/storage/{{$item->company_id}}/items/{{$item->item_img.$i}}" alt="{{$item->product_name}}"></div>
          @endif
          @endfor --}}

        </div>
      </div>
      <div class="col-12 col-sm-6">
        <h1 class="h3 my-3">{{$item->product_name}}</h1>
        @if($item->brand_name)
        <h3 class="h5 my-3">{{$item->brand_name}}</h3>
        @endif

        <h4 class="h6">品番:{{$item->product_code}}</h4>
        @if($item->barcode)
        <h4 class="h6">JAN:{{$item->barcode}}</h4>
        @endif
        @if($item->color_name and $item->size_name)
        <h5 class="h6 text-sm">カラー:{{$item->color_name}} / サイズ:{{$item->size_name}}</h5>
        @elseif($item->color_name and !$item->size_name)
        <h5 class="h6 text-sm">カラー:{{$item->color_name}}</h5>
        @elseif(!$item->color_name and $item->size_name)
        <h5 class="h6 text-sm">カラー:{{$item->size_name}}</h5>
        @else
        @endif
        @if($sku->shelf_number)
        <h5 class="h6 text-sm">棚番号:{{$sku->shelf_number}}</h5>
        @endif
        @if($sku->catch_copy)
        <p>{{$sku->catch_copy}}</p>
        @endif
        <hr>
        <h5 class="h6 text-sm">[{{$store_info->store_name}}] の取扱情報</h5>
        @if($valiations)
        <h4>バリエーション <small class="h6 text-sm">※在庫の<i class="fas fa-phone"></i>は要問い合わせ</small></h4>


        <div class="table-responsive color-group" style="height: 300px;">

          <table class="table table-head-fixed table-bordered table-hover text-nowrap" style="width:100% ">
            <thead>
              <tr>
                {{-- <th style="width: 10px">#</th>
                  <th>カラー</th>
                  <th>サイズ</th>
                  <th style="width: 40px">在庫</th> --}}
                <th style="width: 10%">#</th>
                <th style="width: 50%">カラー</th>
                <th style="width: 25%">サイズ</th>
                <th style="width: 15%">在庫</th>
              </tr>
            </thead>
            <tbody>
              @foreach($valiations as $val)
              <tr data-href="/item/{{$val->company_id}}/{{$val->product_code}}">
                <td>{{$loop->iteration}}.</td>
                <td class="text-truncate">
                  {{-- @dd($val) --}}
                  @isset($val->color_code)
                  <i class="nav-icon fas fa-square" style="color:{{$val->color_code}}"></i>
                  @endisset
                  {{$val->color_name}}</td>
                <td class="text-truncate">{{$val->size_name}}</td>
                {{-- @dd($val) --}}
                @if($val->stock_set === 0)
                <td><i class="fas fa-phone"></i></td>
                @elseif($val->stock_set === 1 and $val->stock_amount === 0)
                <td><i class="fas fa-times"></i></td>
                @elseif($val->stock_set === 1 and $val->stock_amount > 0 and $val->stock_amount < 10) <td><i class="far fa-circle"></i></td>
                  @elseif($val->stock_set === 1 and $val->stock_amount > 9)
                  <td><i class="fas fa-bullseye"></i></td>
                  @else
                  <td><i class="fas fa-question"></i></td>
                  @endif
                  {{-- <td>@dd($val)<span class="badge bg-danger">55%</span></td> --}}
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>


        {{-- <h4>Available Colors</h4> --}}
        {{-- <div class="btn-group btn-group-toggle color-group d-flex align-items-stretch flex-wrap" data-toggle="buttons">
            @foreach($valiations as $val)
            <a href="/item/{{$val->company_id}}/{{$val->product_code}}" class="d-block btn btn-default text-center color-box @if($loop->first) active @endif">
        <input type="radio" name="color_option" id="color_option_a{{$loop->iteration}}" autocomplete="off" @if($loop->first) checked="" @endif>
        @isset($val->color->color_code)
        <i class="fas fa-circle fa-2x" style="color:{{$val->color->color_code}}"></i><br>
        @endisset
        <span class="color-box-text">{{$val->color_name}}</span>
        </a>
        @endforeach
      </div> --}}
      @endif
      {{-- <h4 class="mt-3">サイズ <small>size</small></h4>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <label class="btn btn-default text-center">
            <input type="radio" name="color_option" id="color_option_b2" autocomplete="off">
            <span class="text-xl">M</span>
            <br>
            Medium
          </label>
          <label class="btn btn-default text-center">
            <input type="radio" name="color_option" id="color_option_b3" autocomplete="off">
            <span class="text-xl">L</span>
            <br>
            Large
          </label>
          <label class="btn btn-default text-center">
            <input type="radio" name="color_option" id="color_option_b4" autocomplete="off">
            <span class="text-xl">XL</span>
            <br>
            Xtra-Large
          </label>
        </div> --}}

      <div class="bg-gray py-2 px-3 mt-4">
        <h4 class="mt-0">
          <small>Price: </small>
        </h4>
        <h2 class="mb-0">
          {{$price}}
        </h2>
        {{-- <h4 class="mt-0">
            <small>Ex Tax: $80.00 </small>
          </h4> --}}
      </div>

      {{-- <div class="mt-4">
          <div class="btn btn-primary btn-lg btn-flat">
            <i class="fas fa-cart-plus fa-lg mr-2"></i>
            Add to Cart
          </div>

          <div class="btn btn-default btn-lg btn-flat">
            <i class="fas fa-heart fa-lg mr-2"></i>
            Add to Wishlist
          </div>
        </div> --}}

      {{-- SNSボタンそのうち追加で…
        <div class="mt-4 product-share">
          <a href="#" class="text-gray">
            <i class="fab fa-facebook-square fa-2x"></i>
          </a>
          <a href="#" class="text-gray">
            <i class="fab fa-twitter-square fa-2x"></i>
          </a>
          <a href="#" class="text-gray">
            <i class="fas fa-envelope-square fa-2x"></i>
          </a>
          <a href="#" class="text-gray">
            <i class="fas fa-rss-square fa-2x"></i>
          </a>
        </div> --}}
      <hr>
      <div class="mt-4">
        <address>
          <strong><i class="fas fa-store"></i> {{$store_info->store_name}}</strong><br>
          〒&nbsp;{{ $store_info->store_postcode }}&nbsp;{{ $store_info->prefecture }}{{ $store_info->store_city }}{{ $store_info->store_adnum }}
          @if($store_info->store_apart)<br>{{ $store_info->store_apart }}@endif
        </address>

        <strong><i class="fas fa-phone mr-1"></i> TEL</strong>
        <p class="text-muted">{{ $store_info->store_phone_number }}</p>

        @if($store_info->store_fax_number)
        <strong><i class="fas fa-fax mr-1"></i> FAX</strong>
        <p class="text-muted">{{ $store_info->store_fax_number }}</p>
        @endif

        @if($store_info->store_email)
        <strong><i class="far fa-envelope mr-1"></i> E-MAIL</strong>
        <p class="text-muted">{{ $store_info->store_email }}</p>
        @endif

        @if($store_info->access)
        <strong><i class="fas fa-map-marker-alt mr-1"></i> @lang('common.access')</strong>
        <p class="text-muted">{{ $store_info->access }}</p>
        @endif

        @if($store_info->pay_info)
        <strong><i class="fas fa-cash-register mr-1"></i> @lang('common.pay_info')</strong>
        <p class="text-muted">{{ $store_info->pay_info }}</p>
        @endif

        @if($store_info->opening_hour)
        <strong><i class="fas fa-door-open mr-1"></i> @lang('common.opening_hour')</strong>
        <p class="text-muted">{{ $store_info->opening_hour }}</p>
        @endif

        @if($store_info->closed_day)
        <strong><i class="fas fa-store-slash mr-1"></i> @lang('common.closed_day')</strong>
        <p class="text-muted">{{ $store_info->closed_day }}</p>
        @endif

        @if($store_info->parking)
        <strong><i class="fas fa-parking mr-1"></i> @lang('common.parking')</strong>
        <p class="text-muted">{{ $store_info->parking }}</p>
        @endif

        @if($store_info->store_info)
        <strong><i class="far fa-file-alt mr-1"></i> お店からのお知らせ</strong>
        <p class="text-muted">{{ $store_info->store_info }}</p>
        @endif
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <nav class="w-100">
      <div class="nav nav-tabs" id="product-tab" role="tablist">
        <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">商品説明</a>
        <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">商品詳細</a>
        <a class="nav-item nav-link" id="store-location-tab" data-toggle="tab" href="#store-location" role="tab" aria-controls="store-location" aria-selected="false">お店の場所</a>
        <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">他の取扱店情報</a>
      </div>
    </nav>
    <div class="tab-content p-3 w-100" id="nav-tabContent">
      <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">{{$item->description}}</div>
      <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">{{$item->size}}</div>
      <div class="tab-pane fade" id="store-location" role="tabpanel" aria-labelledby="store-locations-tab">
        <div class="gmap">
          <div id="target"></div>
        </div>
      </div>
      <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">
        <ul class="products-list product-list-in-card pl-2 pr-2">
          @foreach($item_lists as $item_list)
          <li class="item">
            <div class="product-img">
              <img src="{ asset('img/no_image.png') }}" data-src="/storage/{{$item_list['company_id']}}/items/{{$item_list['item_img1']}}" alt="{{$item_list['product_name']}}" class="lazyload img-thumbnail img-size-50" decoding="async" onerror="this.src='{{ asset('img/no_image.png') }}';">
            </div>
            <div class="product-info">
              <a href="/item/{{$item_list['store_id']}}/{{$item_list['product_code']}}" class="product-title">{{$item_list['product_name']}}
                <ul class="float-right item-badge">
                  <li class="text-right"><span class="badge badge-danger">{!!$item_list['price_set']!!}</span></li>
                  <li class="text-right"><span class="badge badge-success">お店からの距離：{{$item_list['distance']}}m</span></li>
                  @if($item_list['shelf_number'])
                  <li class="text-right"><span class="badge badge-info">棚番号：{{ $item_list['shelf_number'] }}</span></li>
                  @endif
                  </ul>
              </a>
              <span class="product-description">
                <i class="fas fa-store"></i> {{$item_list['store_name']}}
              </span>
            </div>
          </li>
          <!-- /.item -->
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  </div>
  <!-- /.card-body -->
  </div>
</section>

@stop

@section('result-right-sidebar')
test
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
  .color-group {
    width: 100%;
  }

  .product-image-thumb {
    margin-bottom: 1rem;
    width: 15%;
  }

  .gmap {
    height: 0;
    overflow: hidden;
    padding-bottom: 56.25%;
    position: relative;
  }

  .gmap #target {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
  }

  #target {
    width: 100%;
    height: 75vh !important;
  }

  img.lazyload:not([src]) {
    visibility: hidden;
  }
  .item-badge{
    list-style: none;
  }
  .item-badge li{
    margin-bottom: .2rem;
  }
</style>
@stop

@section('js')
<script>
  (function ($) {
  'use strict'
  $('.product-image-thumb').on('click', function () {
    var image_element = $(this).find('img')
    $('.product-image').prop('src', $(image_element).attr('src'))
    $('.product-image-thumb.active').removeClass('active')
    $(this).addClass('active')
  })
})(jQuery)

jQuery( function($) {
    $('tbody tr[data-href]').addClass('clickable').click( function() {
        window.location = $(this).attr('data-href');
    }).find('a').hover( function() {
        $(this).parents('tr').unbind('click');
    }, function() {
        $(this).parents('tr').click( function() {
            window.location = $(this).attr('data-href');
        });
    });
});
</script>
<script>
  'use strict';

  function initMap() {

    navigator.geolocation.getCurrentPosition(function(position) {
    var formlat = position.coords.latitude;
    var formlng = position.coords.longitude;
    document.getElementById("lat").value = formlat;
    document.getElementById("lng").value = formlng;
    }, errorCallback);

    var lat = {!! $location->latitude !!};
    var lng = {!! $location->longitude !!};
    var mapPosition = new google.maps.LatLng( lat,lng );//緯度経度
    var map = new google.maps.Map(document.getElementById('target'), {
    zoom: 15,//ズーム
    center: mapPosition,
    disableDefaultUI: true,
    zoomControl: true,
    scaleControl: true,
    styles: [{
        "featureType": "administrative.land_parcel",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "poi",
        "elementType": "labels.text",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "poi.business",
        "stylers": [{
          "visibility": "off"
        }]
      },
      {
        "featureType": "road.local",
        "elementType": "labels",
        "stylers": [{
          "visibility": "off"
        }]
      }
    ],
    });

    // マーカーのセット
    var icon;
    new google.maps.Marker({
      position: mapPosition, // マーカーを立てる位置を指定
      map: map, // マーカーを立てる地図を指定
      icon: icon // アイコン指定
    });

  };

/***** 位置情報が取得できない場合 *****/
function errorCallback(error) {
  var err_msg = "";
  switch (error.code) {
    case 1:
      err_msg = "位置情報の利用が許可されていません";
      break;
    case 2:
      err_msg = "デバイスの位置が判定できません";
      break;
    case 3:
      err_msg = "タイムアウトしました";
      break;
  }
document.getElementById('target').innerHTML = err_msg;
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key={{ config('const.map_key') }}&callback=initMap" async defer></script>
<script src="{{ asset('js/lazysizes.min.js') }}" async=""></script>
@stop