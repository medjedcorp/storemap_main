@extends('adminlte::page')

@section('title', 'カタログ商品の詳細 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">@lang('catalog.show.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">@lang('catalog.show.title')</li>
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
      <div class="col-lg-10">

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-book"></i> @lang('catalog.show.card_title')
            </h3>
          </div>
          @include('partials.success')
          <div class="card-body">
            <dl class="row company-show">
              <dt class="col-sm-3">@lang('catalog.index.maker_name')</dt>
              <dd class="col-sm-9">{{ $item->company->company_name }}</dd>

              <dt class="col-sm-3">@lang('item.product_name')</dt>
              <dd class="col-sm-9">{{ $item->product_name }}</dd>

              <dt class="col-sm-3">@lang('item.product_code')</dt>
              <dd class="col-sm-9">{{ $item->product_code }}</dd>

              <dt class="col-sm-3">@lang('common.barcode')</dt>
              <dd class="col-sm-9">{{ $item->barcode }}</dd>

              <dt class="col-sm-3">@lang('common.brand')</dt>
              <dd class="col-sm-9">{{ $item->brand_name }}</dd>

              @isset( $item->color->color_list )
              <dt class="col-sm-3">@lang('common.color')</dt>
              <dd class="col-sm-9">{{ $item->color->color_list }}</dd>
              @endisset

              <dt class="col-sm-3">@lang('common.original_price')</dt>
              <dd class="col-sm-9">{{ $item->original_price }}</dd>

              <dt class="col-sm-3">@lang('item.description')</dt>
              <dd class="col-sm-9">{{ $item->description }}</dd>

              <dt class="col-sm-3">@lang('item.group_code')</dt>
              <dd class="col-sm-9 h6">
                @isset($item->group_code_id)
                {{ $item->group_code->group_code }}
                @endisset
              </dd>

              <dt class="col-sm-3">@lang('item.sm_cate')</dt>
              <dd class="col-sm-9">{{ $smcate }}</dd>

              <dt class="col-sm-3">@lang('common.update_at')</dt>
              <dd class="col-sm-9">{{ $item->updated_at }}</dd>


              <dt class="col-sm-3">@lang('item.photo')</dt>
              @if($base_company == 1)
              <dd class="col-sm-4">
                @isset($img_list)
                <div id="itemimg" class="carousel slide pointer-event" data-ride="carousel">
                  <ol class="carousel-indicators">
                    @foreach($img_list as $key)
                    <li data-target="#itemimg" data-slide-to="{{ $loop->index }}" class="@if($loop->first) active @endif"></li>
                    @endforeach
                  </ol>
                  <div class="carousel-inner">
                    @foreach($img_list as $key)
                    <div class="carousel-item @if($loop->first) active @endif">
                      <img src="{{ asset('storage/'. $item->company_id . '/items/' . $key) }}" class="d-block w-100" alt="{{ $item->product_name }}">
                    </div>
                    @endforeach
                  </div>
                  <a class="carousel-control-prev" href="#itemimg" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#itemimg" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
                @endisset
              </dd>
              @else
              <dd class="col-sm-4">@lang('catalog.show.no_use')</dd>
              @endif
            </dl>
          </div>
          <div class="card-footer">
            @can('isSeller')
            <div class="form-row d-flex justify-content-between">
              @if (isset($copy_id))
              <button type="submit" onclick="location.href='{{ route('items.edit', $copy_id->id) }}'" class="btn btn-info mr-1 ml-3"><i class="fa fa-pencil-square-o"></i> @lang('catalog.show.copy_look')</button>
              @else
              <form method="POST" action="{{ route('catalog.copy' , $item->id ) }}" class="h-adr">
                @method('post')
                @csrf
                <button type="submit" class="btn btn-info mr-1 ml-3"><i class="fas fa-copy"></i> @lang('catalog.show.copy_btn')</D>
              </form>
              @endif
              @endcan
              <button class="btn btn-default float-right" onclick="location.href='{{ route('catalog.index') }}'"><i class="fa fa-reply"></i> @lang('common.back')</button>
            </div>
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
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')

@stop