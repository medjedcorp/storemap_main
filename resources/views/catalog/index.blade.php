@extends('adminlte::page')

@section('title', 'カタログ出品 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">@lang('catalog.index.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">@lang('catalog.index.title')</li>
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
      <div class="col-12">
        <!-- Horizontal Form -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-book"></i> @lang('catalog.index.card_title')
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @include('partials.success')
            @include('partials.danger')
            <form id="catalogSearch" action="/catalog" class="" method="GET">
              @csrf
              @method('get')
              <div class="input-group input-group-lg mb-4">
                <input form="catalogSearch" type="text" name="keyword" class="form-control " placeholder="商品コード・商品名・JANコードで検索" value="{{$keyword}}">
                <span class="input-group-append">
                  <button type="sbumit" class="btn btn-info btn-flat"><i class="fas fa-search"></i></button>
                </span>
              </div>
            </form>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-nowrap">@lang('item.product_code')</th>
                  <th class="text-nowrap">@lang('item.product_name')</th>
                  <th class="text-nowrap">@lang('common.original_price')</th>
                  <th class="text-nowrap">@lang('common.barcode')</th>
                  <th class="text-nowrap">@lang('catalog.index.maker_name')</th>
                  <th class="text-nowrap" style="width:100px;">@lang('common.info')</th>
                </tr>
              </thead>
              <tbody>
                @isset($items)
                @foreach($items as $item)
                <tr>
                  <td>{{($item->product_code)}}</td>
                  <td>{{($item->product_name)}}</td>
                  <td>{{($item->original_price)}}</td>
                  <td>{{($item->barcode)}}</td>
                  <td>{{($item->company->company_name)}}</td>
                  <td><button class="btn btn-sm btn-success" onclick="location.href='{{ route('catalog.show' , $item->id ) }}'"><i class="fas fa-book-reader"></i> 詳細</button></td>
                </tr>
                @endforeach
                @endisset
                @empty($items)
                <tr>
                  <td colspan="6" class="text-center p-4">
                    <p>出品したい商品のJANコード、商品コード、商品名のいずれかで検索してください</p>
                  </td>
                </tr>
                @endempty
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <!-- Loading (remove the following to stop the loading)-->
          <div id="loading" class="overlay dark">
            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
          </div>
          <!-- end loading -->

          <div class="card-footer clearfix">
            @isset($items)
            {{ $items->appends(request()->input())->links() }}
            @endisset
          </div>
        </div>
        <!-- /.card -->
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
                <h5>カタログ出品</h5>
                <hr class="mb-2">
                <p>メーカー登録された商品の検索ができます。自社で取り扱いのある商品で、メーカー登録済みの商品を検索して、商品情報をコピーすることで商品を素早く出品できます。<br>カタログ一括出品では、csvを利用してJANコードのみで商品情報を一括コピー出来ます。</p>
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
<script>
  jQuery(window).on('load', function() {
    jQuery('#loading').hide();
  });
</script>
@stop