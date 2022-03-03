@extends('adminlte::store-page')

@section('title', $store_info->store_name)

@section('content_header')
<h1><i class="fas fa-info-circle"></i> {{ $store_info->store_name }}の情報</h1>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            {{-- <div class="text-center">
              <img
                src="{{ asset('storage/'. $store_info->company_id . '/stores/' . $store_info->store_img1) }}"
            alt="{{ $store_info->store_name }}">
          </div> --}}

          @if($img_list)
          <div id="storeImgArea" class="carousel slide pointer-event" data-ride="carousel">
            <ol class="carousel-indicators">
              @foreach($img_list as $key)
              <li data-target="#storeImgArea" data-slide-to="{{ $loop->index }}"
                class="@if($loop->first) active @endif"></li>
              @endforeach
            </ol>
            <div class="carousel-inner">
              @foreach($img_list as $key)
              <div class="carousel-item @if($loop->first) active @endif">
                <img src="{{ asset('storage/'. $store_info->company_id . '/stores/' . $key) }}"
                  class="d-block w-100 card-img" alt="{{ $store_info->store_name }}">
              </div>
              @endforeach
            </div>
            <a class="carousel-control-prev" href="#storeImgArea" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#storeImgArea" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
          @else
          <div class="carousel">
            <div class="no-img"><img src="{{ asset('img/no_image600x450.png') }}" alt="{{ $store_info->store_name }}"
                class="d-block w-100 card-img"></div>
          </div>
          @endif

          <address>
          <h3 class="profile-username text-center"><strong>{{ $store_info->store_name }}</strong></h3>

          <p class="text-muted text-center">
            〒&nbsp;{{ $store_info->store_postcode }}&nbsp;{{ $store_info->prefecture }}{{ $store_info->store_city }}{{ $store_info->store_adnum }}
            @if($store_info->store_apart)<br>{{ $store_info->store_apart }}@endif
          </p>
          </address>
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>商品数</b> <a class="float-right">{{$count_item}}</a>
            </li>
            {{-- <li class="list-group-item">
                  <b>店舗カテゴリ</b> <a class="float-right">{{$cate_count}}</a>
            </li> --}}
            <li class="list-group-item">
              <b>店舗業種</b> <a class="float-right">{{$store_info->industry->industry_name}}</a>
            </li>
          </ul>
          {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

      <!-- About Me Box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">店内商品検索</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form id="itemSearch" action="/store/{{$store_info->id}}" class="mb-4" method="GET">
            @csrf
            @method('get')
            <div class="input-group md-form form-sm form-2 pl-0">
              <input class="form-control my-0 py-1" type="text" placeholder="Search" name="keyword"
                value="@isset($keyword){{$keyword}}@endisset" aria-label="Search">
              <div class="input-group-append">
                <button class="input-group-text lighten-3" id="basic-text1"><i class="fas fa-search text-grey"
                    aria-hidden="true"></i></button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

      <!-- About Me Box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">詳細情報</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong><i class="fas fa-phone mr-1"></i>TEL</strong>
          <p class="text-muted">
            {{ $store_info->store_phone_number }}
          </p>

          @if($store_info->store_fax_number)
          <hr>
          <strong><i class="fas fa-fax mr-1"></i> FAX</strong>
          <p class="text-muted">{{ $store_info->store_fax_number }}</p>
          @endif

          @if($store_info->store_email)
          <hr>
          <strong><i class="far fa-envelope mr-1"></i> E-MAIL</strong>
          <p class="text-muted">{{ $store_info->store_email }}</p>
          @endif

          @if($store_info->access)
          <hr>
          <strong><i class="fas fa-map-marker-alt mr-1"></i> @lang('common.access')</strong>
          <p class="text-muted">{{ $store_info->access }}</p>
          @endif

          @if($store_info->pay_info)
          <hr>
          <strong><i class="fas fa-cash-register mr-1"></i> @lang('common.pay_info')</strong>
          <p class="text-muted">{{ $store_info->pay_info }}</p>
          @endif

          @if($store_info->opening_hour)
          <hr>
          <strong><i class="fas fa-door-open mr-1"></i> @lang('common.opening_hour')</strong>
          <p class="text-muted">{{ $store_info->opening_hour }}</p>
          @endif

          @if($store_info->closed_day)
          <hr>
          <strong><i class="fas fa-store-slash mr-1"></i> @lang('common.closed_day')</strong>
          <p class="text-muted">{{ $store_info->closed_day }}</p>
          @endif

          @if($store_info->parking)
          <hr>
          <strong><i class="fas fa-parking mr-1"></i> @lang('common.parking')</strong>
          <p class="text-muted">{{ $store_info->parking }}</p>
          @endif

          @if($store_info->store_info)
          <hr>
          <strong><i class="far fa-file-alt mr-1"></i> お店からのお知らせ</strong>
          <p class="text-muted">{{ $store_info->store_info }}</p>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            @isset($cate_name->category_name)
            <li class="nav-item"><a class="nav-link active" href="#itemlist" data-toggle="tab"><i
                  class="far fa-list-alt mr-1"></i>{{$cate_name->category_name}}一覧</a></li>
            @else
            <li class="nav-item"><a class="nav-link active" href="#itemlist" data-toggle="tab"><i
                  class="far fa-list-alt mr-1"></i>商品一覧</a></li>
            @endisset
            <li class="nav-item"><a class="nav-link" href="#location" data-toggle="tab"><i
                  class="fas fa-map-marker-alt mr-1"></i>お店の場所</a></li>
            <li class="nav-item"><a class="nav-link" href="#calendar" data-toggle="tab"><i
                  class="far fa-calendar-alt mr-1"></i>カレンダー</a></li>
            @isset($store_info->flyer_img)
            <li class="nav-item"><a class="nav-link" href="#flyer" data-toggle="tab"><i
                  class="fas fa-file-invoice-dollar mr-1"></i>チラシ</a></li>
            @endisset
            @isset($store_info->floor_guide)
            <li class="nav-item"><a class="nav-link" href="#floor" data-toggle="tab"><i
                  class="far fa-map mr-1"></i>フロアガイド</a></li>
            @endisset
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="itemlist">
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">

                  @forelse($store_items as $store_item)
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="{{ asset('img/no_image.png') }}"
                        data-src="/storage/{{$store_info->company_id}}/items/{{$store_item['item_img1']}}"
                        alt="{{$store_item['product_name']}}" class="lazyload img-thumbnail" decoding="async"
                        onerror="this.src='{{ asset('img/no_image.png') }}';">
                    </div>
                    <div class="product-info">
                      <a href="/item/{{$store_item['store_id']}}/{{$store_item['product_code']}}" id="event{{@$loop->index}}" class="product-title">
                        <h3 class="h5">{{$store_item['product_name']}}</h3>
                        <div class="float-right">
                          <h6 class="text-right"><span class="badge badge-danger">{!! $store_item['price'] !!}</span>
                          </h6>
                          <h6 class="text-right"><span class="badge badge-warning"
                              style="display:block;">{{ $store_item['stocks'] }}</span></h6>
                          @if($store_item['shelf_number'])
                          <h6 class="text-right"><span class="badge badge-info"
                              style="display:block;">棚番号：{{ $store_item['shelf_number'] }}</span></h6>
                          @endif
                        </div>
                        @if($store_item['catch_copy'])
                        <h5 class="product-description h6">
                          <i class="far fa-clipboard"></i>&nbsp;{{$store_item['catch_copy']}}
                        </h5>
                        @endif

                        @if($store_item['start_date'])
                        <h6 class="text-danger text-sm">
                          セール期間:{{$store_item['start_date']}}&nbsp;〜&nbsp;{{$store_item['end_date']}}</h6>
                        @endif
                        <small class="text-muted">
                          Last updated&nbsp;{{$store_item['updated_at']}}
                        </small>
                      </a>
                    </div>
                  </li>
                  @empty
                  <!-- /.item -->
                  <li class="item">※検索結果はありませんでした
                  </li>
                  @endforelse
                </ul>
                @if ($store_items->hasMorePages())
                {{$store_items->appends(request()->query())->links()}}
                @endif
              </div>

            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="location">
              <div class="gmap">
                <div id="target"></div>
              </div>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="calendar">
              <div class="card">
                <div class="card-body">
                  <div id='calendar' class="fc fc-ltr fc-bootstrap card-text"></div>
                </div>
              </div>
            </div>

            @isset($store_info->flyer_img)
            <div class="tab-pane" id="flyer">
              <div class="card">
                <div class="card-body">
                  <img src="/storage/{{$store_info->company_id}}/stores/{{$store_info->flyer_img}}" loading="lazy">
                </div>
              </div>
            </div>
            @endisset

            @isset($store_info->floor_guide)
            <div class="tab-pane" id="floor">
              <div class="card">
                <div class="card-body">
                  <img src="/storage/{{$store_info->company_id}}/stores/{{$store_info->floor_guide}}" loading="lazy">
                </div>
              </div>
            </div>
            @endisset
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@stop

{{-- @section('result-right-sidebar')
test
@stop --}}

@section('footer')
<div class="footer-area">
  <div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
  {!! config('const.manage.footer') !!}
</div>
@stop

@section('css')
<link href="{{asset('css/fullcalendar/core/main.css')}}" rel='stylesheet' />
<link href="{{asset('css/fullcalendar/daygrid/main.css')}}" rel='stylesheet' />
<link href="{{asset('css/fullcalendar/timegrid/main.css')}}" rel='stylesheet' />
<link href="{{asset('css/fullcalendar/list/main.css')}}" rel='stylesheet' />
<link href="{{asset('css/fullcalendar/style.css')}}" rel='stylesheet' />
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
<link rel="stylesheet" href="/css/admin_custom.css">
<style type="text/css">
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

  .carousel-inner:before {
    content: "";
    display: block;
    padding-top: 75%;
  }

  .carousel-inner .carousel-item {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
  }

  .products-list .product-img img {
    width: 120px;
    height: 120px;
  }

  .products-list .product-info {
    margin-left: 130px;
  }

  .flex-form-area {
    flex-grow: 1;
  }

  .flex-form {
    flex-grow: 0.2;
  }

  img.lazyload:not([src]) {
    visibility: hidden;
  }

  .fc-view {
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
  }
</style>
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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



<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/lazysizes.min.js') }}" async=""></script>

<script src="{{asset('js/fullcalendar/core/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/interaction/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/daygrid/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/timegrid/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/list/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/core/locales-all.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="{{asset('js/fullcalendar/jquery.mask.min.js')}}"></script>
<script>
  window.sid = {{$store_info->id}};
</script>
<script src="{{asset('js/fullcalendar/show/ajax-setup.js')}}"></script>
<script src="{{asset('js/fullcalendar/show/fullcalendar.js')}}"></script>
<script src="{{asset('js/fullcalendar/show/event-control.js')}}"></script>

@stop