@extends('layouts.map')

@section('title', 'StoreMap')

@section('content')
<div class="row">
  <div id="prefbox" class="col-1 mb-3">
    <div class="accordion overflow-auto scrollarea" id="pref_area">
      <div class="card">
        <div class="card-header" id="headingZero">
          <h5 class="mb-0">
            <div class="h5">
              @if(isset($pcity) and isset($pward))
              {{$pname}}<br>{{$pcity}}<br>{{$pward}}
              @elseif(isset($pcity) and empty($pward))
              {{$pname}}<br>{{$pcity}}
              @else
              {{$pname}}
              @endif
            </div>
          </h5>
        </div>
      </div>
      @foreach($pgroups as $group=>$value)
      <div class="card">
        @if(!empty($value[0]['ward']))
        // 大阪府羽曳野市とか
        <a class="card-header" id="heading{{$loop->iteration}}">
        @else
        // 大阪府大阪市北区とか
        <a href="/pref/{{$pname}}/{{$group}}" class="card-header" id="heading{{$loop->iteration}}">
        @endif
          <h5 class="mb-0">
              <button class="btn btn-sm btn-link collapsed" type="button" data-toggle="collapse"
                data-target="#collapse{{$loop->iteration}}" aria-expanded="false"
                aria-controls="collapse{{$loop->iteration}}">
                {{$group}}
              </button>
          </h5>
        </a>
          @foreach($value as $v)
          // cityからwardを抜き出し
          @if(!empty($v['ward']))
          // wardが空じゃない場合はwardを入れる
          <div id="collapse{{$loop->parent->iteration}}" class="collapse ward"
            aria-labelledby="heading{{$loop->parent->iteration}}" data-parent="#pref_area">
            <div class="card-body">
              <a href="/pref/{{$pname}}/{{$group}}/{{$v['ward']}}">{{$v['ward']}}</a>
            </div>
          </div>
          @endif
          @endforeach
      </div>
      @endforeach
    </div>
  </div>

  <div class="col-md-5 col-lg-6 col-xl-7 mb-3">
    <div id="target"></div>
  </div>
  <div id="sidebox" class="col-md-6 col-lg-5 col-xl-4 mb-3">
    <div class="loading none">
      <div class="fa-3x">
        <div class="text-center"><i class="fas fa-cog fa-spin"></i></div>
        <p class="h6 text-center">Now Loading..</p>
      </div>
    </div>
    <div id="sidebar" class="overflow-auto scrollarea">
      @forelse($pstores as $pstore)
      <a href="javascript:void(0)" onclick="myclick({{@$loop->index}})" id="event{{@$loop->index}}"
        class="item_list card mb-1 result" style="width:100%;">
        <div class="row no-gutters">
          <div class="col-3 col-md-4 col-lg-3 col-xl-3 p-1 lazyitem">
            <img src="{{ asset('img/no_image.png') }}"
              data-src="/storage/{{$pstore->company_id}}/stores/{{$pstore->store_img1}}" class="card-img lazyload"
              alt="{{$pstore->store_name}}" decoding="async">
          </div>
          <div class="col-8 col-md-8 col-lg-7 col-xl-9">
            <div class="card-body">
              <h3 class="card-title h5"><i class="fas fa-store"></i>&nbsp;{{$pstore->store_name}}</h3>
              <p class="card-text d-block text-dark">
                <i class="fas fa-map-marker-alt"></i>
                &nbsp;{{$pstore->prefecture. $pstore->store_city. $pstore->store_adnum}}{{$pstore->store_apart}}<br>
                <i class="fas fa-phone"></i>&nbsp;{{$pstore->store_phone_number}}<br>
                <small class="text-muted"><i class="fas fa-clock"></i>&nbsp;Last updated
                  {{$pstore->updated_at}}<br>業種:{{$pstore->industry_name}}</small>
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
  var marker = [];
  var infoWindow = [];
  var map;

  function initMap() {

    //マップ初期表示の位置設定
    var target = document.getElementById('target');

    var uluru = {lat: {!! $first_place->latitude !!}, lng:{!! $first_place->longitude !!}}

    var map = new google.maps.Map(target, {
        center: uluru,
        zoom: 15,
        disableDefaultUI: true,
        zoomControl: true,
        scaleControl: true,
        styles:[
          {
            "featureType": "administrative.land_parcel",
            "elementType": "labels",
            "stylers": [
              {
                "visibility": "off"
              }
            ]
          },
          {
            "featureType": "poi",
            "elementType": "labels.text",
            "stylers": [
              {
                "visibility": "off"
              }
            ]
          },
          {
            "featureType": "poi.business",
            "stylers": [
              {
                "visibility": "off"
              }
            ]
          },
          {
            "featureType": "road.local",
            "elementType": "labels",
            "stylers": [
              {
                "visibility": "off"
              }
            ]
          }
        ],
       }, errorCallback
      );

      //  var marker = new google.maps.Marker({position: uluru, map: map});

      var markerData = {!! $pstores !!};
      var event = [];
 
       
      for (var i = 0; i < markerData.length; i++) {

        var latNum = parseFloat(markerData[i]['latitude']);
        var lngNum = parseFloat(markerData[i]['longitude']);

        let update = moment(markerData[i]['updated_at']).format("YYYY-MM-DD HH:mm");

        var sid = markerData[i]['id'];
        var sname = markerData[i]['store_name'];
        var cid = markerData[i]['company_id'];
        var simg1 = markerData[i]['store_img1'];
        var pcode = markerData[i]['store_postcode'];
        var address = markerData[i]['prefecture'] + markerData[i]['store_city'] +  markerData[i]['store_adnum'] + markerData[i]['store_apart'];
        var tel = markerData[i]['store_phone_number'];
        var info = markerData[i]['store_info'];
        var email = markerData[i]['email'];
        var industry = markerData[i]['industry_name'];
        event.push('event' + [i]);
        if (!email){
        email = '';
        }
        // マーカー位置セット
        var markerLatLng = new google.maps.LatLng({
          lat: latNum,
          lng: lngNum
        });

        // マーカーのセット
        marker[i] = new google.maps.Marker({
          position: markerLatLng,          // マーカーを立てる位置を指定
          map: map,                        // マーカーを立てる地図を指定
        });

          // 吹き出しの追加
        infoWindow[i] = new google.maps.InfoWindow({
          content: '<div class="card mb-2" style="width: 100%;"><div class="row no-gutters"><div class="col-sm-12 col-md-12 col-lg-4 store_thum"><img src="{{ asset('img/no_image.png') }}" data-src="/storage/'+ cid + '/stores/' + simg1 + '" class="card-img lazyload ml-1" alt="' + sname + '" decoding="async"></div><div class="col-sm-12 col-md-12 col-lg-8"><div class="card-body"><h5 class="card-title">' + sname + '</h5><p class="card-text">' + info + '<br>〒&nbsp;' + pcode + '<br><i class="fas fa-map-marker-alt"></i>&nbsp;' + address + '<br><i class="fas fa-phone"></i>&nbsp;' + tel + '<br><i class="far fa-envelope"></i>&nbsp;' + email + '</p><p class="card-text"><a href="/store/'+ sid +'" class="store_search">店舗と取扱商品を表示&nbsp;<i class="fas fa-arrow-circle-right"></i></a></p></div></div></div></div>'
        });

        markerEvent(i);

      }
  // Marker clusterの追加
  var markerCluster = new MarkerClusterer(
    map,
    marker,
    {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'}
  );

};

  var openWindow;

  function markerEvent(i) {
  marker[i].addListener('click', function() {
    myclick(i);
  });
  }

  function myclick(i) {
  if(openWindow){
    openWindow.close();
  }
  infoWindow[i].open(map, marker[i]);
  openWindow = infoWindow[i];
  }



/***** 位置情報が取得できない場合 *****/
function errorCallback(error) {
  var err_msg = "";
  switch(error.code)
  {
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

<script
  src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyCHk2iy5q2LXe4CIaMP3BdMQusE78r9qx0&callback=initMap"
  async defer></script>
@endsection