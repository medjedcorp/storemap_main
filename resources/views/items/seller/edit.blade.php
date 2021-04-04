@extends('adminlte::page')

@section('title', '販売店情報の編集 - Storemap Cockpit')

@section('content_header')
<h1><span class="h4"><i class="fas fa-edit"></i> {{$item->product_name}}/<span class="h5">{{$item->product_code}} の
      @lang('item.price.title')</span></span></h1>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-12">
        <div class="card card-primary card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
              <li class="pt-2 px-3">
                <h3 class="card-title"><i class="far fa-list-alt"></i> @lang('item.seller.card_title')</h3>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-base-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-base" aria-selected="false" onclick="location.href='{{ route('items.edit' , $item->id ) }}'">@lang('item.main.base')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-two-store-tab" data-toggle="pill" href="seller" role="tab" aria-controls="custom-tabs-two-store" aria-selected="true">@lang('item.main.store')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-price-tab" data-toggle="pill" href="price" role="tab" aria-controls="custom-tabs-two-price" aria-selected="false" onclick="location.href='{{ route('items.price.edit' , $item->id ) }}'">@lang('item.main.price')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-stock-tab" data-toggle="pill" href="stock" role="tab" aria-controls="custom-tabs-two-stock" aria-selected="false" onclick="location.href='{{ route('items.stock.edit' , $item->id ) }}'">@lang('item.main.stock')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-comment-tab" data-toggle="pill" href="comment" role="tab" aria-controls="custom-tabs-two-comment" aria-selected="true" onclick="location.href='{{ route('items.comment.edit' , $item->id ) }}'">@lang('item.main.comment')</a>
              </li>
            </ul>
          </div>

          @include('partials.errors')
          @include('partials.success')

          <div class="card-body">
            <h5 class="mt-2 mb-4">@lang('item.seller.explain')</h5>
            @foreach ($stores as $store)
            <hr>
            <div class="form-group row">
              <div class="col-sm-2">
                <input form="seller_form" type="checkbox" data-on-color="success" name="selling_flag[]" id="customCheck{{($store->id)}}" value="{{($store->id)}}" @if( ($item->store()->find($store->id)->pivot->selling_flag ) == 1) checked
                @endif >
              </div>
              <div class="col-sm-10">
                <label for="customCheck{{($store->id)}}">{{ $store->store_name }}</label>
              </div>
            </div>
            
            @endforeach
            @foreach ($errors->get('store_id.*') as $message)
            <div class="small text-danger">※{{$errors->first('store_id.*')}}</div>
            @endforeach
          </div>
          <!-- /.card -->
          <!-- /.card-body -->
          <div class="card-footer">
            <form id="seller_form" method="POST" action="{{ route('items.seller.update', $item->id) }}" enctype="multipart/form-data" class="h-adr inline_form">
              @csrf
              @method('PATCH')
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>
                @lang('item.seller.submit')</button>
            </form>
            <button class="btn btn-default float-right" onclick="location.href='{{ route('items.index') }}'"><i class="fa fa-reply"></i> @lang('common.back')</button>
          </div>
          <!-- /.card-footer -->
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
                <h5>取扱店舗の設定</h5>
                <hr class="mb-2">
                <p>店舗ごとに商品を取り扱っているか設定できます。「ON」が表示されていると、商品の取扱店舗として検索結果に表示されます。</p>
            </div>
        </div>
    </div>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap-switch.min.js') }}"></script>
<script>
  $("[name='selling_flag[]']").bootstrapSwitch();
</script>
@stop