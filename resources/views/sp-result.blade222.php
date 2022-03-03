@extends('adminlte::result-page')

@section('title', 'Storemap：ストアマップでの検索結果')

@section('content_header')
<h1>SPの画面</h1>
@stop

@section('content')

{{-- <div id="loading">
  <div class="spinner">
    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
    <p style="margin:5px 0 0 -5px;">Loading...</p>
  </div>
</div> --}}

<section class="content">
  <div class="container-fluid mr-1 mt-2">
    <div id="itembox">
      <div class="card card-outline">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
          <h3 class="card-title">
            <i class="fas fa-shopping-cart"></i>
            <span id="countArea">近隣：
              @isset($store_items)
              {{count($store_items)}}
              @endisset
              件の情報を表示</span>
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
        <div class="card-body item-scroll p-0">
          @isset($warning)
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> {{ $warning }}</h5>
            位置情報を許可してください
          </div>
          @endisset
          <div class="tab-content p-0">
            <!-- Morris chart - Sales -->
            <div class="tab-pane active " id="list-area">
              <ul id="sidebar" class="products-list product-list-in-card pl-2 pr-2">
                @isset($store_items)
                @forelse($store_items as $store_item)
                <li class="item">
                  <div class="product-img">
                    <img src="{{ asset('img/no_image.png') }}" data-src="/storage/{{$store_item['company_id']}}/items/{{$store_item['item_img1']}}" alt="{{$store_item['store_name']}} / {{$store_item['product_name']}}" class="lazyload" decoding="async" onerror="this.src='{{ asset('img/no_image.png') }}';">
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
                      <small class="text-muted">Last updated&nbsp;{{$store_item['updated_at']}}<br>他{{$store_item['count']}}件のHit</small>
                    </a>
                  </div>
                </li>
                @empty
                <li class="item">※検索結果はありませんでした</li>
                @endforelse
                @endisset
                <!-- /.item -->
              </ul>
            </div>
            <div class="tab-pane" id="store-area">
              <ul id="store-item-list" class="products-list product-list-in-card pl-2 pr-2"></ul>
            </div>
          </div>
        </div>
        <div class="card-footer">※在庫や価格を保証するものではありません。商品情報の詳細は店舗へ直接お問い合わせください</div>
        <div class="overlay dark loading none">
          <i class="fas fa-3x fa-sync-alt fa-spin"></i>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>


@stop

@section('footer')
<div class="footer-area">
  <div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
  {!! config('const.manage.footer') !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
  .loaded {
    opacity: 0;
    visibility: hidden;
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
    height: 80px;
    width: 80px;
}
.products-list .product-info {
    margin-left: 90px;
}
</style>
@stop

@section('js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/lazysizes.min.js') }}" async=""></script>
<script>
  $(window).on('load', function() {
  // 初回ロード時に起動
    // firstMarker(markerD);
    const spinner = document.getElementById('loading');
    spinner.classList.add('loaded');
  })

</script>
@stop