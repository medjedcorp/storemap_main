@extends('adminlte::result-page')

@section('title', 'Storemap：ストアマップでの検索結果')

@section('content_header')
{{-- <h1>Dashboard</h1> --}}
@stop

@section('content')
<section class="content">
  <div class="container-fluid">

    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-ban"></i> 現在はテスト版です</h5>
      現在テスト中です。商品の登録を行っても予告なく削除されます。本運用までお待ちください。
    </div>

    <div class="row">
      <!-- left column -->
      <div class="col-xl-7 col-12">
        <div class="card card-success card-outline">
          <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-map-marker-alt mr-1"></i>
              お店の位置 <small class="d-none d-md-inline">※MAPをクリックすると、クリックした箇所から近いお店が表示されます。</small>
            </h3>
          </div>
          <div class="card-body p-0">
            <div class="gmap">
              <div id="target"></div>
            </div>
          </div>
          <!-- /.card-body-->
          <div class="card-footer">
            <small>※在庫や価格を保証するものではありません。商品情報の詳細は店舗へ直接お問い合わせください。
            </small>
          </div>
        </div>
      </div>
      <div id="sidebox" class="col-xl-5 col-12">
        <div class="card">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-shopping-cart"></i>
              <span id="countArea">近隣：{{count($store_items)}}件の情報を表示</span>
            </h3>
            <div class="card-tools">
              <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                  <a class="nav-link active" href="#list-area" data-toggle="tab" id="item-list-btn">近隣順</a>
                </li>
                <li class="nav-item d-none" id="store-list-btn-area">
                  <a class="nav-link" href="#store-area" data-toggle="tab" id="store-list-btn">店舗内</a>
                </li>
              </ul>
            </div>
          </div>

          <div class="card-body item-scroll">
            <div class="tab-content p-0">
              <!-- Morris chart - Sales -->
              <div class="tab-pane active " id="list-area">
                <ul id="sidebar" class="products-list product-list-in-card pl-2 pr-2">
                  @forelse($store_items as $store_item)
                  <li class="item">
                    <div class="product-img">
                      <img src="{{ asset('img/no_image.png') }}" data-src="/storage/{{$store_item['company_id']}}/items/{{$store_item['item_img1']}}" alt="{{$store_item['store_name']}} / {{$store_item['product_name']}}" class="img-size-64 lazyload" decoding="async" onerror="this.src='{{ asset('img/no_image.png') }}';">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" onclick="myclick({{@$loop->index}})" id="event{{@$loop->index}}" class="product-title">
                        {{$store_item['product_name']}}
                        <div class="float-right">
                          <h6 class="text-right"><span class="badge badge-danger">{!! $store_item['price'] !!}</span></h6>
                          <h6 class="text-right"><span class="badge badge-success" style="display:block;"> 距離:約{{$store_item['distance']}}</span></h6>
                          <h6 class="text-right"><span class="badge badge-warning" style="display:block;">{{ $store_item['stocks'] }}</span></h6>
                        </div>
                        <span class="product-description">
                          <i class="fas fa-store"></i>&nbsp;{{$store_item['store_name']}}
                        </span>
                        <small class="text-muted">Last updated&nbsp;{{$store_item['updated_at']}}<br>他{{$store_item['count']}}件のHit</small></a>
                    </div>
                  </li>
                  @empty
                  <li class="item">※検索結果はありませんでした
                  </li>
                  @endforelse
                  <!-- /.item -->
                </ul>
              </div>
              <div class="tab-pane" id="store-area">
                <ul id="store-item-list" class="products-list product-list-in-card pl-2 pr-2"></ul>
              </div>
            </div>
          </div>
          <div class="card-footer"><small>&nbsp;</small></div>
          <div class="overlay dark loading none">
            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
  </div><!-- /.container-fluid -->
</section>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
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

  .none {
    visibility: hidden;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
    -ms-transition: all 0.5s;
    -o-transition: all 0.5s;
    transition: all 0.5s;
    opacity: 0;
  }

  .products-list .product-img img {
    height: 64px;
    width: 64px;
  }

  a.product-title {
    display: block;
  }

  .products-list .product-info {
    margin-left: 74px;
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

  #sidebar ul.nav li {
    font-size: 0.9rem;
  }

  #sidebar ul.nav li p {
    max-width: 170px;
  }

  #target .card {
    box-shadow: none;
    border: 1px solid #cbcbcb;
  }

  .item-scroll {
    height: 0;
    overflow-x: hidden;
    padding-bottom: 100%;
    position: relative;
  }

  .item-scroll #list-area,
  .item-scroll #store-area {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
  }

  .nav-sidebar>.no-wrap {
    white-space: nowrap;
  }

  #countArea,
  #item-list-btn,
  #store-list-btn {
    font-size: 0.75rem;
  }

  .card-footer{
    background-color: #fff;
  }
  @media (min-width: 576px) {
    #countArea,
    #item-list-btn,
    #store-list-btn {
      font-size: 0.85rem;
    }
  }

  @media (min-width: 768px) {

    #countArea,
    #item-list-btn,
    #store-list-btn {
      font-size: 0.95rem;
    }
  }

  @media (min-width: 992px) {
  }

  @media (min-width: 1200px) {
    .gmap{
      padding-bottom: 75vh;
    }
    .item-scroll {
    height: 75vh;
    }
  }
</style>
@stop

@section('js')
<script src="https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/src/markerclusterer.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/lazysizes.min.js') }}" async=""></script>
<script>
  'use strict';

  function initMap() {

    //マップ初期表示の位置設定
    var target = document.getElementById('target');

    //マップ表示
    navigator.geolocation.getCurrentPosition(function(position) {

      @isset($req_pref)
      var uluru = {lat: {!! $lat !!}, lng:{!! $lng !!}}
      var lat = {!! $lat !!};
      var lng = {!! $lng !!};
      @else
      var lat = position.coords.latitude;
      var lng = position.coords.longitude;
      @endisset

      document.getElementById("lat").value = lat;
      document.getElementById("lng").value = lng;
      map = new google.maps.Map(target, {
        @isset($req_pref)
        center: uluru,
        @else
        center: {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        },
        @endisset
        zoom: 15,
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

            // クリックイベントを追加
            map.addListener('click', function(e) {
          // クリック時の座標を取得
        getClickLatLng(e.latLng, map);
      });

    }, errorCallback);

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

  function getClickLatLng(lat_lng, map) {
    // 座標を表示
    document.getElementById('lat').textContent = lat_lng.lat();
    document.getElementById('lng').textContent = lat_lng.lng();
    document.getElementById('lat').value = lat_lng.lat();
    document.getElementById('lng').value = lat_lng.lng();
    // // マーカーを設置
    // var marker = new google.maps.Marker({
    // position: lat_lng,
    // map: map
    // });

    // クリックした場所に移動
    map.panTo(lat_lng);    
}

  var markerD = [];


$(window).on('load', function() {
  // 初回ロード時に起動
  firstMarker(markerD);
})


function firstMarker() {
//マーカー生成＆セット
var markerData = {!! $store_items !!};
var icon;

for (var i = 0; i < markerData.length; i++) {

    var latNum = parseFloat(markerData[i]['latitude']);
    var lngNum = parseFloat(markerData[i]['longitude']);

    let update = moment(markerData[i]['updated_at']).format("YYYY-MM-DD HH:mm");
    var sid = markerData[i]['id'];
    var cid = markerData[i]['company_id'];
    var keyword = markerData[i]['keyword'];
    var iimg1 = markerData[i]['item_img1'];
    var simg1 = markerData[i]['store_img1'];
    var email = markerData[i]['store_email'];
    var emailBox = '<br><i class="far fa-envelope"></i>&nbsp;' + email;
    var storeInfo = markerData[i]['store_info'];
    var storeInfoBox = '<i class="fas fa-bullhorn"></i>&nbsp;' + storeInfo + '<br>';
    // 検索時にシングルクォーテーションが入るように
    var keyword = `\'` + keyword + `\'`;

    if (!email) {
      emailBox = '';
    }
    if (!storeInfo) {
      storeInfoBox = '';
    }
    // マーカー位置セット
    var markerLatLng = new google.maps.LatLng({
      lat: latNum,
      lng: lngNum
    });
    // マーカーのセット
    marker[i] = new google.maps.Marker({
      position: markerLatLng, // マーカーを立てる位置を指定
      map: map, // マーカーを立てる地図を指定
      icon: icon // アイコン指定
    });
    // 吹き出しの追加
    infoWindow[i] = new google.maps.InfoWindow({
      content: '<div class="card mb-2" style="width: 100%;"><div class="row no-gutters"><div class="col-4 store_thum"><img src="{{ asset('img/no_image.png') }}" data-src="/storage/' + cid + '/stores/' + simg1 + '" class="card-img lazyload" alt="' + markerData[i]['store_name'] + '" decoding="async" onerror="this.src=' + noimg + ';"></div><div class="col-8" style="display:block;"><div class="card-body"><h5 class="card-title">' + markerData[i]['store_name'] + '</h5><p class="card-text">' + storeInfoBox + '〒&nbsp;' + markerData[i]['store_postcode'] + '<br><i class="fas fa-map-marker-alt"></i>&nbsp;' + markerData[i]['store_address'] + '<br><i class="fas fa-phone"></i>&nbsp;' + markerData[i]['store_phone_number']  + emailBox + '</p><p class="card-text mb-1"><a href="#store-area" onclick="itemclick(' + sid + ',' + keyword + ')" class="store_search_item" data-toggle="tab">検索商品の一覧を表示&nbsp;<i class="fas fa-arrow-circle-right"></i></a></p><p class="card-text"><a href="/store/' + sid + '" class="store_search">店舗と取扱商品を表示&nbsp;<i class="fas fa-arrow-circle-right"></i></a></p></div></div></div></div>'
    });
    // マーカーにクリックイベントを追加
    markerEvent(i);
  }
}

  $(function() {
      // DB情報の取得(ajax)
      $('#search-form').submit(function() {
        // HTMLでの送信をキャンセル
        event.preventDefault();

        // 操作対象のフォーム要素を取得
        var $form = $(this);

        // 送信ボタンを取得
        var $button = $form.find('button');

        // キーワード取得
        var keyword_text = document.getElementById("keyword-area").value;
        // カテゴリと都道府県に一括セット
        var keyword_class = document.getElementsByClassName('set-keyword');
        for( var $i = 0; $i < keyword_class.length; $i++ ) {
          keyword_class[$i].value = keyword_text;
        }
        // document.getElementsByClassName('set-keyword').value = keyword_text;
        // console.log(keyword_text);
        // document.form1.keyword.value = keyword_text;
        // document.form2.keyword.value = keyword_text;
        // document.form3.keyword.value = keyword_text;
        // $(function(){
        $.ajax({
            type: "GET",
            url: "/ajax/smcate",
            // $form.serialize()で得られる値をそのまま利用可能
            data: $form.serialize(),
            dataType: "json",
            timeout: 20000, // 単位はミリ秒
            // 送信前
            beforeSend: function() {
              // ボタンを無効化し、二重送信を防止
              $button.attr('disabled', true);
              $('.loading').removeClass('none');
            },
            // // 応答後
            complete: function(xhr, textStatus) {
              // ボタンを有効化し、再送信を許可
              $button.attr('disabled', false);
            },
          }).done(function(data) {
            $('.loading').addClass('none');
            $("#item-list-btn").addClass("active");
            $("#store-list-btn-area").addClass("d-none");
            markerD = data;
            setMarker(markerD);
            // console.log(data);
          })
          .fail(function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("failed...");
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
            alert('Error : ' + errorThrown);
          });
      });
    });

      var map;
      var marker = [];
      var infoWindow = [];
      var noimg = "'{{ asset('img/no_image.png') }}'";

    function setMarker(markerData) {

      // console.log(markerData);
      // console.log(markerData.length);

      //マーカー生成
      var sidebar1_html = "";
      var count_html = "";
      var icon;

      if (markerData.length == 0) {
        count_html += '近隣：0件の情報を表示';
        sidebar1_html += '<li class="item">※検索結果はありませんでした</li>';
      }

      for (var i = 0; i < markerData.length; i++) {

        var latNum = parseFloat(markerData[i]['latitude']);
        var lngNum = parseFloat(markerData[i]['longitude']);

        let update = moment(markerData[i]['updated_at']).format("YYYY-MM-DD HH:mm");
        var sid = markerData[i]['id'];
        var cid = markerData[i]['company_id'];
        var keyword = markerData[i]['keyword'];
        var iimg1 = markerData[i]['item_img1'];
        var simg1 = markerData[i]['store_img1'];
        var smid = markerData[i]['smid'];
        var stocks = markerData[i]['stocks'];
        var email = markerData[i]['store_email'];
        var emailBox = '<br><i class="far fa-envelope"></i>&nbsp;' + email;
        var storeInfo = markerData[i]['store_info'];
        var storeInfoBox = '<i class="fas fa-bullhorn"></i>&nbsp;' + storeInfo + '<br>';
        // 検索時にシングルクォーテーションが入るように
        var keyword = `\'` + keyword + `\'`;

        if (!email) {
          emailBox = '';
        }
        if (!storeInfo) {
          storeInfoBox = '';
        }
        // マーカー位置セット
        var markerLatLng = new google.maps.LatLng({
          lat: latNum,
          lng: lngNum
        });
        // マーカーのセット
        marker[i] = new google.maps.Marker({
          position: markerLatLng, // マーカーを立てる位置を指定
          map: map, // マーカーを立てる地図を指定
          icon: icon // アイコン指定
        });
        // 吹き出しの追加
        infoWindow[i] = new google.maps.InfoWindow({
          content: '<div class="card mb-2" style="width: 100%;"><div class="row no-gutters"><div class="col-4 store_thum"><img src="{{ asset('img/no_image.png') }}" data-src="/storage/' + cid + '/stores/' + simg1 + '" class="card-img lazyload" alt="' + markerData[i]['store_name'] + '" decoding="async" onerror="this.src=' + noimg + ';"></div><div class="col-8" style="display:block;"><div class="card-body"><h5 class="card-title">' + markerData[i]['store_name'] + '</h5><p class="card-text">' + storeInfoBox + '〒&nbsp;' + markerData[i]['store_postcode'] + '<br><i class="fas fa-map-marker-alt"></i>&nbsp;' + markerData[i]['store_address'] + '<br><i class="fas fa-phone"></i>&nbsp;' + markerData[i]['store_phone_number'] + emailBox + '</p><p class="card-text mb-1"><a href="#store-area" onclick="itemclick(' + sid + ',' + keyword + ')" class="store_search_item" data-toggle="tab">検索商品の一覧を表示&nbsp;<i class="fas fa-arrow-circle-right"></i></a></p><p class="card-text"><a href="/store/' + sid + '" class="store_search">店舗と取扱商品を表示&nbsp;<i class="fas fa-arrow-circle-right"></i></a></p></div></div></div></div>'
        });

        sidebar1_html += '<li class="item"><div class="product-img"><img src="{{ asset('img/no_image.png') }}" alt="' + markerData[i]['product_name'] + '" data-src="/storage/' + cid + '/items/' + iimg1 + '" class="img-size-64 lazyload" decoding="async" onerror="this.src=' + noimg + ';"></div><div class="product-info"><a href="javascript:myclick(' + i + ')" class="product-title">' + markerData[i]['product_name'] + '<div class="float-right"><h6 class="text-right"><span class="badge badge-danger">' + markerData[i]['price'] + '</span></h6><h6 class="text-right"><span class="badge badge-success" style="display:block;"> 距離:約' + markerData[i]['distance'] + '</span></h6><h6 class="text-right"><span class="badge badge-warning" style="display:block;">' + stocks + '</span></h6></div><span class="product-description"><i class="fas fa-store"></i>&nbsp;' + markerData[i]['store_name'] + '</span><small class="text-muted">Last updated&nbsp;' + update + '<br>他' + markerData[i]['count'] + '件のHit</small></a></div></li>';

        count_html = '近隣：'+ markerData.length +'件の情報を表示';

        // マーカーにクリックイベントを追加
        markerEvent(i);
      }

      // Marker clusterの追加
      var markerCluster = new MarkerClusterer(
        map,
        marker, {
        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
        }
      );

      // サイドバー
      document.getElementById("sidebar").innerHTML = sidebar1_html;
      // document.getElementById("store-item-list").innerHTML = sidebar2_html;
      document.getElementById("countArea").innerHTML = count_html;
      document.getElementById("smid").innerHTML = smid;
    }

    var openWindow;

    function markerEvent(i) {
      marker[i].addListener('click', function() {
        myclick(i);
      });
    }

    function myclick(i) {
      // console.log(i);
      if (openWindow) {
        openWindow.close();
      }
      infoWindow[i].open(map, marker[i]);
      openWindow = infoWindow[i];
    }

    var storeItemD = [];

    function itemclick(id, keyword) {
      console.log(id,keyword);
        $.ajax({
          type: 'GET',
          // ルーティングで設定したURL
          url: `/ajax/itemlist/${id}/${keyword}`, // 引数も渡せる
          dataType: 'json',
          timeout: 20000, // 単位はミリ秒
          beforeSend: function() {
            $('.loading').removeClass('none');
          },
        }).done(function(data) {
          console.log(data);
          $('.loading').addClass('none');
          storeItemD = data;
          storeItem(storeItemD);
        }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
          console.log("failed...");
          console.log("XMLHttpRequest : " + XMLHttpRequest.status);
          console.log("textStatus     : " + textStatus);
          console.log("errorThrown    : " + errorThrown.message);
          alert('Error : ' + errorThrown);
        });

          $("#item-list-btn").removeClass("active");
          $("#store-list-btn-area").removeClass("d-none");
          $("#store-list-btn").addClass("active");
       }

      function storeItem(itemData) {

        console.log(itemData);
        console.log(itemData.length);

        //マーカー生成
        var sidebar2_html = "";
        var count_html = "";

        if (itemData.length == 0) {
          sidebar2_html += '<li class="item">※検索結果はありませんでした</li>';
      }

        for (var i = 0; i < itemData.length; i++) {

          let update_at = moment(itemData[i]['updated_at']).format("YYYY-MM-DD HH:mm");
          var sid = itemData[i]['id'];
          var cid = itemData[i]['company_id'];
          var keyword = itemData[i]['keyword'];
          var iimg1 = itemData[i]['item_img1'];
          var shelf = itemData[i]['shelf_number'];
          var stocks = itemData[i]['stocks'];

          console.log(shelf);
          console.log(update_at);

          if (!shelf) {
            var shelf_num = '';
          } else {
            var shelf_num = '棚番号:' + shelf + '&nbsp;/&nbsp;';
          }

          if (update == 'Invalid date') {
            var update = '';
          } else {
            var update = update_at;
          }
          console.log(shelf_num);
          console.log(update);


          sidebar2_html += '<li class="item"><div class="product-img"><img src="{{ asset('img/no_image.png') }}" alt="' + itemData[i]['product_name'] + '" data-src="/storage/' + cid + '/items/' + iimg1 + '" class="img-size-64 lazyload" decoding="async" onerror="this.src=' + noimg + ';"></div><div class="product-info"><a href="javascript:void(0)" class="product-title">' + itemData[i]['product_name'] + '<div class="float-right"><h6 class="text-right"><span class="badge badge-danger">' + itemData[i]['price'] + '</span></h6><h6 class="text-right"><span class="badge badge-warning" style="display:block;">' + stocks + '</span></h6></div><span class="product-description"><i class="fas fa-store"></i>&nbsp;' + itemData[i]['store_name'] + '</span><small class="text-muted">' + shelf_num + 'Last updated&nbsp;' + update + '</small></a></div></li>';

          count_html = itemData[i]['store_name'] + '：'+ itemData.length +'件の情報を表示';

        }

        // サイドバー
        // document.getElementById("sidebar").innerHTML = sidebar1_html;
        document.getElementById("store-item-list").innerHTML = sidebar2_html;
        document.getElementById("countArea").innerHTML = count_html;
        
      }
      
</script>
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key={{ config('const.map_key') }}&callback=initMap" async defer></script>
@stop