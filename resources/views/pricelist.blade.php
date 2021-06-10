@extends('adminlte::top-page')

@section('title', 'Storemap：ストアマップ / 掲載について')

@section('content_header')
{{-- <h1>ストアマップ / 掲載について</h1> --}}
@stop

@section('content_top_nav_left')

@stop

@section('content_top_nav_right')
{{-- ヘッダー右エリア --}}
@stop

{{-- @section('content_header')

@stop --}}

@section('content')

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-6">
        <a href="/publish" class="text-dark">
        <div class="info-box mb-3">
          <span class="info-box-icon"><i class="fas fa-map-marked-alt"></i></span>
          <div class="info-box-content">
            <h3 class="h5 mb-0"><strong>掲載について</strong></h3>
            <span class="info-box-text">Publish on the site</span>
          </div>
          <!-- /.info-box-content -->
        </div>
      </a>
      </div>
      <div class="col-6">
          <div class="info-box mb-3 bg-warning">
            <span class="info-box-icon"><i class="far fa-credit-card"></i></span>
            <div class="info-box-content">
              <h3 class="h5 mb-0"><strong>料金表</strong></h3>
              <span class="info-box-text">Price list</span>
            </div>
            <!-- /.info-box-content -->
          </div>
      </div>

      <div class="col-12">
        <div class="alert alert-danger alert-dismissible">
          <h5><i class="icon fas fa-ban"></i> ※ご契約について</h5>
          ご契約は会社単位でお願い致します。店舗単位で契約されるとAPIによる在庫・価格連動機能や、商品情報や店舗の管理などが利用できません。
        </div>
      </div>

      <div id="select-course" class="row">
        <div class="col-6 col-md-3">
            <div class="card card-info">
                <div class="card-header">
                    <h5 class="m-0">ライト</h5>
                </div>
                <div class="card-body">
                    <div class="callout callout-info">
                        <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.light_price')) }}<small class="h6 ml-1">円</small></h3>
                        <small>※お試しで使ってみたいお店向け</small>
                    </div>
                    <ul>
                        <li>{{number_format(config('services.stripe.light_item'))}}商品まで登録可能</li>
                        <li>画像容量100MByteまで利用可能</li>
                        <li>1店舗は追加課金なしで利用可能</li>
                        <li>{{config('services.stripe.trial')}}日の無料お試し期間</li>
                        <li>初期費用無料</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-warning">
                <div class="card-header">
                    <h5 class="m-0">ベーシック</h5>
                </div>
                <div class="card-body">
                    <div class="callout callout-warning">
                        <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.basic_price')) }}<small class="h6 ml-1">円</small></h3>
                        <small>※取扱商品点数が多いお店向け</small>
                    </div>
                    <ul>
                        <li>{{number_format(config('services.stripe.basic_item'))}}商品まで登録可能</li>
                        <li>画像容量10GByteまで利用可能</li>
                        <li>1店舗は追加課金なしで利用可能</li>
                        <li>{{config('services.stripe.trial')}}日の無料お試し期間</li>
                        <li>API連携が利用可能</li>
                        <li>初期費用無料</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-success">
                <div class="card-header">
                    <h5 class="m-0">プレミアム</h5>
                </div>
                <div class="card-body">
                    <div class="callout callout-success">
                        <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.premium_price')) }}<small class="h6 ml-1">円</small></h3>
                        <small>※取扱商品点数が非常に多い大型店舗向け</small>
                    </div>
                    <ul>
                        <li>{{number_format(config('services.stripe.premium_item'))}}商品まで登録可能</li>
                        <li>画像容量50GByteまで利用可能</li>
                        <li>1店舗は追加課金なしで利用可能</li>
                        <li>{{config('services.stripe.trial')}}日の無料お試し期間</li>
                        <li>API連携が利用可能</li>
                        <li>初期費用無料</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-danger">
                <div class="card-header">
                    <h5 class="m-0">追加店舗
                    </h5>
                </div>
                <div class="card-body">
                    <div class="callout callout-danger">
                        <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.add_store'))}}<small class="h6 ml-1">円 / 1店舗</small></h3>
                        <small>※1店舗追加ごとに+{{number_format(config('services.stripe.add_store'))}}円</small>
                    </div>
                    <ul>
                        <li>1店舗ごとに+{{number_format(config('services.stripe.add_store'))}}円/月</li>
                        <li>{{config('services.stripe.trial')}}日の無料お試し期間</li>
                        <li>最初の1店舗はプラン内の料金に含まれています。2店舗以上運用の場合、必要になります。</li>
                        <li>初期費用無料</li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- /.row -->
    </div>

    
      <div class="col-12">
        @include('partials.footerlink')
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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop