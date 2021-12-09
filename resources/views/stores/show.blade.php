@extends('adminlte::page')

@section('title', '店舗情報の詳細 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-7">
      <h1 class="m-0">{{$c_name}} / @lang('store.edit.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-5">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/stores">店舗一覧</a></li>
        <li class="breadcrumb-item active">店舗詳細</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-10">

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-store"></i>
              {{ $store->store_name }}の @lang('store.view.card_title')
            </h3>
          </div>
          <div class="card-body">
          @include('partials.success')
            <dl class="row company-show">
              <dt class="col-sm-3">@lang('store.register.store_name')</dt>
              <dd class="col-sm-9">{{ $store->store_name }}</dd>

              @if (App::isLocale('ja')) {{-- 日本語のときだけ表示 --}}
              <dt class="col-sm-3">店舗名かな</dt>
              <dd class="col-sm-9">{{ $store->store_kana }}</dd>
              @endif

              <dt class="col-sm-3">@lang('store.register.store_code')</dt>
              <dd class="col-sm-9">{{ $store->store_code }}</dd>

              <dt class="col-sm-3">@lang('common.postcode')</dt>
              <dd class="col-sm-9">{{ $store->store_postcode }}</dd>

              <dt class="col-sm-3">@lang('common.address')</dt>
              <dd class="col-sm-9">{{$store->prefecture . $store->store_city . $store->store_adnum.' '.$store->store_apart}}</dd>

              <dt class="col-sm-3">@lang('common.phone_number')</dt>
              <dd class="col-sm-9">{{ $store->store_phone_number }}</dd>

              @if( $store->store_fax_number)
              <dt class="col-sm-3">@lang('common.fax_number')</dt>
              <dd class="col-sm-9">{{ $store->store_fax_number }}</dd>
              @endif
              
              <dt class="col-sm-3">@lang('common.email')</dt>
              <dd class="col-sm-9">{{ $store->store_email }}</dd>

              <dt class="col-sm-3">@lang('store.pause_flag')</dt>
              @if( $store->pause_flag == 1 )
              <dd class="col-sm-9">@lang('store.show')</dd>
              @elseif ( $store->pause_flag == 0 )
              <dd class="col-sm-9">@lang('store.hide')</dd>
              @endif

              @if( $store->store_info)
              <dt class="col-sm-3">@lang('store.info')</dt>
              <dd class="col-sm-9">{{ $store->store_info }}</dd>
              @endif
              
              <dt class="col-sm-3">@lang('store.industry')</dt>
              <dd class="col-sm-9">{{ $store->industry->industry_name }}</dd>

              @if( $store->store_url)
              <dt class="col-sm-3">@lang('store.url')</dt>
              <dd class="col-sm-9">{{ $store->store_url }}</dd>
              @endif

              @if( $store->flyer_img)
              <dt class="col-sm-3">@lang('store.flyer')</dt>
              <dd class="col-sm-9">{{ $store->flyer_img }}</dd>
              @endif

              @if( $store->floor_guide)
              <dt class="col-sm-3">@lang('store.floor_guide')</dt>
              <dd class="col-sm-9">{{ $store->floor_guide }}</dd>
              @endif

              @if( $store->pay_info)
              <dt class="col-sm-3">@lang('store.pay_info')</dt>
              <dd class="col-sm-9">{{ $store->pay_info }}</dd>
              @endif

              @if( $store->access)
              <dt class="col-sm-3">@lang('store.access')</dt>
              <dd class="col-sm-9">{{ $store->access }}</dd>
              @endif

              @if( $store->opening_hour)
              <dt class="col-sm-3">@lang('store.opening_hour')</dt>
              <dd class="col-sm-9">{{ $store->opening_hour }}</dd>
              @endif

              @if( $store->closed_day)
              <dt class="col-sm-3">@lang('store.closed_day')</dt>
              <dd class="col-sm-9">{{ $store->closed_day }}</dd>
              @endif

              @if( $store->parking)
              <dt class="col-sm-3">@lang('store.parking')</dt>
              <dd class="col-sm-9">{{ $store->parking }}</dd>
              @endif

              <dt class="col-sm-3">@lang('common.latitude')</dt>
              <dd class="col-sm-9">{{ $lat['latitude'] }}</dd>

              <dt class="col-sm-3">@lang('common.longitude')</dt>
              <dd class="col-sm-9">{{ $lng['longitude'] }}</dd>

              <dt class="col-sm-3">@lang('store.photo')</dt>
              <dd class="col-sm-4">
                @isset($img_list)
                <div id="storeimg" class="carousel slide pointer-event" data-ride="carousel">
                  <ol class="carousel-indicators">
                    @foreach($img_list as $key)
                    <li data-target="#storeimg" data-slide-to="{{ $loop->index }}" class="@if($loop->first) active @endif"></li>
                    @endforeach
                  </ol>
                  <div class="carousel-inner">
                    @foreach($img_list as $key)
                    <div class="carousel-item @if($loop->first) active @endif">
                      <img src="{{ asset('storage/'. $store->company_id . '/stores/' . $key) }}" class="d-block w-100" alt="{{ $store->store_name }}">
                    </div>
                    @endforeach
                  </div>
                  <a class="carousel-control-prev" href="#storeimg" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#storeimg" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
                @endisset
              </dd>
            </dl>
          </div>
          <div class="card-footer">
            @can('isSeller')
            <a href="{{ route('stores.edit' , $store->id ) }}" class="btn btn-primary"><i class="fas fa-edit"></i> 店舗情報を編集する</a>
            @endcan
            <button class="btn btn-default float-right" onclick="location.href='{{ route('stores.index') }}'"><i class="fa fa-reply"></i> @lang('common.back')</button>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
  </div><!-- /.container-fluid -->
</section>
@stop

@section('right-sidebar')
    <div class="os-padding text-sm">
        <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
            <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">
                <h5>店舗詳細</h5>
                <hr class="mb-2">
                <p>一覧より選択した店舗の情報が閲覧できます。</p>
                <p>店舗情報を編集するボタンを押すことで、店舗情報の編集が可能です。</p>
            </div>
        </div>
    </div>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style type="text/css">
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
</style>
@stop

@section('js')

@stop