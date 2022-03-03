@extends('adminlte::page')

@section('title', '在庫情報の編集 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-7">
      <h1 class="m-0"><span class="h4"><i class="fas fa-edit"></i> {{$item->product_name}}/<span class="h5">{{$item->product_code}} の
      @lang('item.stock.title')</span></span></h1>
    </div><!-- /.col -->
    <div class="col-sm-5">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/items">商品一覧</a></li>
        <li class="breadcrumb-item active">@lang('item.main.stock')</li>
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
        <div class="card card-primary card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
              <li class="pt-2 px-3">
                <h3 class="card-title"><i class="far fa-list-alt"></i> @lang('item.stock.card_title')</h3>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-base-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-base" aria-selected="false" onclick="location.href='{{ route('items.edit' , $item->id ) }}'">@lang('item.main.base')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-store-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-store" aria-selected="false" onclick="location.href='{{ route('items.seller.edit' , $item->id ) }}'">@lang('item.main.store')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-price-tab" data-toggle="pill" href="price" role="tab" aria-controls="custom-tabs-two-price" aria-selected="false" onclick="location.href='{{ route('items.price.edit' , $item->id ) }}'">@lang('item.main.price')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-two-stock-tab" data-toggle="pill" href="stock" role="tab" aria-controls="custom-tabs-two-stock" aria-selected="true">@lang('item.main.stock')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-comment-tab" data-toggle="pill" href="comment" role="tab" aria-controls="custom-tabs-two-comment" aria-selected="true" onclick="location.href='{{ route('items.comment.edit' , $item->id ) }}'">@lang('item.main.comment')</a>
              </li>
            </ul>
          </div>
          <div class="card-body">            
          @include('partials.errors')
          @include('partials.success')
            <table class="table">
              <thead>
                <tr>
                  <th>@lang('item.store_name')</th>
                  <th>@lang('item.stock.stock_info')</th>
                  <th>@lang('item.stock.value')</th>
                  <th>@lang('item.stock.sort_num')</th>
                  <th>@lang('item.stock.shelf_num')</th>
                </tr>
              </thead>
              <tbody>
                @foreach($itemstock as $itemstock)
                <tr>
                  <td> <input form="stock_form" type="hidden" class="form-control" name="store_id[]" value="{{ $itemstock->pivot->store_id }}">{{ $itemstock->store_name }}</td>
                  <td>
                    <div class="form-group">
                      <select form="stock_form" class="form-control" name="stock_set[]">
                        <option value="1" {{ old('stock_set[$i]', $itemstock->pivot->stock_set) == 1 ? 'selected' : '' }}>
                          @lang('item.stock.set')</option>
                        <option value="0" {{ old('stock_set[$i]', $itemstock->pivot->stock_set) == 0 ? 'selected' : '' }}>
                          @lang('item.stock.no_set')</option>
                      </select>
                  </td>
                  <td>
                    <div class="form-group">
                      <input form="stock_form" type="text" class="form-control" name="stock_amount[]" value="{{ old('stock_amount[$i]', $itemstock->pivot->stock_amount) }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input form="stock_form" type="text" class="form-control" name="sort_num[]" value="{{ old('sort_num[$i]', $itemstock->pivot->sort_num) }}">
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input form="stock_form" type="text" class="form-control" name="shelf_number[]" value="{{ old('shelf_number[$i]', $itemstock->pivot->shelf_number) }}">
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <ul>
              @foreach ($errors->all() as $error)
              <li class="text-danger">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          <!-- /.card -->
          <!-- /.card-body -->
          <div class="card-footer">
            <form id="stock_form" method="POST" action="{{ route('items.stock.update', $item->id) }}" enctype="multipart/form-data" class="h-adr inline_form">
              @csrf
              @method('PATCH')
              <button form="stock_form" type="submit" class="btn btn-primary" value="登録"><i class="fa fa-check-square"></i>
                @lang('item.stock.submit')</button>
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
      <h5>在庫設定</h5>
      <hr class="mb-2">
      <p>店舗ごとに在庫の設定ができます。</p>
      <dl>
        <dt>在庫設定</dt>
        <dd>「しない」を選択すると、無限在庫となります。サービス商品など、特に在庫を設定する必要のない商品は「しない」を選択してください。</dd>
        <dt>在庫数</dt>
        <dd>商品の在庫数が設定できます。在庫設定を「する」で在庫数が
          「0」の場合はサイト上に「在庫なし」と表示されます。</dd>
        <dt>表示優先順位</dt>
        <dd>検索結果画面でキーワードにヒットしたとき、表示優先順位の高い商品から表示されます。整数を入力してください。</dd>
        <dt>棚番号</dt>
        <dd>商品の置いてある棚番号を入力してください。入力があると検索結果画面に表示されます。</dd>
      </dl>
    </div>
  </div>
</div>
@stop

@section('footer')
<div class="footer-area">
  <div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
  {!! config('const.manage.footer') !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')

@stop