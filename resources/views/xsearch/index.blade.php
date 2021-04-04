@extends('layouts.map')

@section('title', 'StoreMap')

@section('content')
<div class="row">
  <div class="col-md-6 col-lg-7 col-xl-8 mb-3">
    <div id="target"></div>
  </div>
  <div id="sidebox" class="col-md-6 col-lg-5 col-xl-4 mb-3">
    <div class="loading none">
      <div class="fa-3x">
        <div class="text-center"><i class="fas fa-cog fa-spin"></i></div>
        <p class="h6 text-center">Now Loading..</p>
      </div>
    </div>
    <div style="width:100%;" id="countArea" class="bg-info text-center text-white mb-1 p-1">
      近隣：{{count($store_items)}}件の情報を表示</div>
    <div id="sidebar" class="overflow-auto scrollarea">

      @forelse($store_items as $store_item)
      {{-- @dd($store_item) --}}
      <a href="javascript:void(0)" onclick="myclick({{@$loop->index}})" id="event{{@$loop->index}}"
        class="item_list card mb-1 result" style="width:100%;">
        <div class="row no-gutters">
          <div class="col-3 col-md-4 col-lg-3 col-xl-3 p-1 lazyitem">
            <img src="{{ asset('img/no_image.png') }}"
              data-src="/storage/{{$store_item['company_id']}}/items/{{$store_item['item_img1']}}"
              class="card-img lazyload" alt="{{$store_item['store_name']}} / {{$store_item['product_name']}}"
              decoding="async">
          </div>
          <div class="col-8 col-md-8 col-lg-7 col-xl-9">
            <div class="card-body">
              <h3 class="card-title h5">{{$store_item['product_name']}}</h3>
              <p class="card-text d-block text-truncate text-dark">
                <span class="text-danger">{!! $store_item['price'] !!}</span>&nbsp;/&nbsp;
                <span class="text-success">距離:約<strong>{{$store_item['distance']}}</strong>
                </span><br>
                <i class="fas fa-store"></i>&nbsp;{{$store_item['store_name']}}<br>
                <small class="text-muted">Last
                  updated&nbsp;{{$store_item['updated_at']}}<br>他{{$store_item['count']}}件のHit</small>
              </p>
            </div>
          </div>
        </div>
      </a>
      @empty
      <div class="item_list card mb-1 result p-4" style="width:100%;">※検索結果はありませんでした</div>
      @endforelse
    </div>
  </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
  integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
@endsection

@section('script')
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

      var lat = position.coords.latitude;
      var lng = position.coords.longitude;
      document.getElementById("lat").value = lat;
      document.getElementById("lng").value = lng;

      map = new google.maps.Map(target, {
        center: {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        },
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

    // 検索時にシングルクォーテーションが入るように
    var keyword = `\'` + keyword + `\'`;

    if (!email) {
      email = '';
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
      content: '<div class="card mb-2" style="width: 100%;"><div class="row no-gutters"><div class="col-sm-12 col-md-12 col-lg-4 store_thum"><img src="{{ asset('img/no_image.png') }}" data-src="/storage/' + cid + '/stores/' + simg1 + '" class="card-img lazyload ml-1" alt="' + markerData[i]['store_name'] + '" decoding="async"></div><div class="col-sm-12 col-md-12 col-lg-8"><div class="card-body"><h5 class="card-title">' + markerData[i]['store_name'] + '</h5><p class="card-text">' + markerData[i]['store_info'] + '<br>〒&nbsp;' + markerData[i]['store_postcode'] + '<br><i class="fas fa-map-marker-alt"></i>&nbsp;' + markerData[i]['store_address'] + '<br><i class="fas fa-phone"></i>&nbsp;' + markerData[i]['store_phone_number'] + '<br><i class="far fa-envelope"></i>&nbsp;' + email + '</p><p class="card-text mb-1"><a href="javascript:void(0)" onclick="itemclick(' + sid + ',' + keyword + ')" class="store_search_item">検索商品の一覧を表示&nbsp;<i class="fas fa-arrow-circle-right"></i></a></p><p class="card-text"><a href="/store/' + sid + '" class="store_search">店舗と取扱商品を表示&nbsp;<i class="fas fa-arrow-circle-right"></i></a></p></div></div></div></div>'
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

        // $(function(){
        $.ajax({
            type: "GET",
            url: "/ajax/search",
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
            // $('.msg').append('<p>NAME: ' + data + '</p>');
            markerD = data;
            setMarker(markerD);
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

    function setMarker(markerData) {

      console.log(markerData);
      console.log(markerData.length);

      //マーカー生成
      var sidebar_html = "";
      var count_html = "";
      var icon;

      if (markerData.length == 0) {
        sidebar_html += '<div class="item_list card mb-1 result p-4" style="width:100%;">※検索結果はありませんでした</div>';
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
        var email = markerData[i]['store_email'];

        // 検索時にシングルクォーテーションが入るように
        var keyword = `\'` + keyword + `\'`;

        if (!email) {
          email = '';
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
          content: '<div class="card mb-2" style="width: 100%;"><div class="row no-gutters"><div class="col-sm-12 col-md-12 col-lg-4 store_thum"><img src="{{ asset('img/no_image.png') }}" data-src="/storage/' + cid + '/stores/' + simg1 + '" class="card-img lazyload ml-1" alt="' + markerData[i]['store_name'] + '" decoding="async"></div><div class="col-sm-12 col-md-12 col-lg-8"><div class="card-body"><h5 class="card-title">' + markerData[i]['store_name'] + '</h5><p class="card-text">' + markerData[i]['store_info'] + '<br>〒&nbsp;' + markerData[i]['store_postcode'] + '<br><i class="fas fa-map-marker-alt"></i>&nbsp;' + markerData[i]['store_address'] + '<br><i class="fas fa-phone"></i>&nbsp;' + markerData[i]['store_phone_number'] + '<br><i class="far fa-envelope"></i>&nbsp;' + email + '</p><p class="card-text mb-1"><a href="javascript:void(0)" onclick="itemclick(' + sid + ',' + keyword + ')" class="store_search_item">検索商品の一覧を表示&nbsp;<i class="fas fa-arrow-circle-right"></i></a></p><p class="card-text"><a href="/store/' + sid + '" class="store_search">店舗と取扱商品を表示&nbsp;<i class="fas fa-arrow-circle-right"></i></a></p></div></div></div></div>'
        });

        sidebar_html += '<a href="javascript:myclick(' + i + ')" class="item_list card mb-1 result" style="width:100%;"><div class="row no-gutters"><div class="col-3 col-md-4 col-lg-3 col-xl-3 p-1 lazyitem"><img src="{{ asset('img/no_image.png') }}" data-src="/storage/' + cid + '/items/' + iimg1 + '" class="card-img lazyload" alt="' + markerData[i]['product_name'] + '" decoding="async"></div><div class="col-8 col-md-8 col-lg-7 col-xl-9"><div class="card-body"><h3 class="card-title h5">' + markerData[i]['product_name'] + '</h3><p class="card-text d-block text-truncate text-dark"><span class="text-danger">' + markerData[i]['price'] + '</span>&nbsp;/&nbsp;<span class="text-success">距離:約<strong>' + markerData[i]['distance'] + '</strong></span><br><i class="fas fa-store"></i>&nbsp;' + markerData[i]['store_name'] + '<br><small class="text-muted">Last updated ' + update + '<br>他' + markerData[i]['count'] + '件のHit</small></p></div></div></div></a>';

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
      document.getElementById("sidebar").innerHTML = sidebar_html;
      document.getElementById("countArea").innerHTML = count_html;
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
          // console.log(data);
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
      }

      function storeItem(itemData) {

        console.log(itemData);
        console.log(itemData.length);

        //マーカー生成
        var sidebar_html = "";
        var count_html = "";

        for (var i = 0; i < itemData.length; i++) {

          let update_at = moment(itemData[i]['updated_at']).format("YYYY-MM-DD HH:mm");
          var sid = itemData[i]['id'];
          var cid = itemData[i]['company_id'];
          var keyword = itemData[i]['keyword'];
          var iimg1 = itemData[i]['item_img1'];
          var shelf = itemData[i]['shelf_number'];

          console.log(shelf);
          console.log(update_at);

          if (shelf == null) {
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


          sidebar_html += '<div class="item_list card mb-1 result" style="width:100%;"><div class="row no-gutters"><div class="col-3 col-md-4 col-lg-3 col-xl-3 p-1 lazyitem"><img src="{{ asset('img / no_image.png') }}" data-src="/storage/' + cid + '/items/' + iimg1 + '" class="card-img lazyload" alt="' + itemData[i]['product_name'] + '" decoding="async"></div><div class="col-8 col-md-8 col-lg-7 col-xl-9"><div class="card-body"><h3 class="card-title h5">' + itemData[i]['product_name'] + '</h3><p class="card-text d-block text-truncate text-dark"><span class="text-danger">' + itemData[i]['price'] + itemData[i]['stock'] + '</span>&nbsp;<br><i class="fas fa-store"></i>  &nbsp;' + itemData[i]['store_name'] + '<br><small class="text-muted">' + shelf_num + 'Last updated:' + update + '</small></p></div></div></div></div>';

          count_html = itemData[i]['store_name'] + '：'+ itemData.length +'件の情報を表示';

        }

        // サイドバー
        document.getElementById("sidebar").innerHTML = sidebar_html;
        document.getElementById("countArea").innerHTML = count_html;
        
      }
</script>

<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyCHk2iy5q2LXe4CIaMP3BdMQusE78r9qx0&callback=initMap" async defer></script>
@endsection