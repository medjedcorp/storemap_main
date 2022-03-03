@extends('adminlte::page')

@section('title', '商品コメントの編集 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-7">
      <h1 class="m-0"><span class="h4"><i class="fas fa-edit"></i> {{$item->product_name}}/<span class="h5">{{$item->product_code}} の
      @lang('item.comment.title')</span></span></h1>
    </div><!-- /.col -->
    <div class="col-sm-5">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/items">商品一覧</a></li>
        <li class="breadcrumb-item active">@lang('item.main.comment')</li>
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
                <a class="nav-link" id="custom-tabs-two-stock-tab" data-toggle="pill" href="stock" role="tab" aria-controls="custom-tabs-two-stock" aria-selected="false" onclick="location.href='{{ route('items.stock.edit' , $item->id ) }}'">@lang('item.main.stock')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-two-comment-tab" data-toggle="pill" href="comment" role="tab" aria-controls="custom-tabs-two-comment" aria-selected="true">@lang('item.main.comment')</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
          @include('partials.errors')
          @include('partials.success')
            <table class="table">
              <thead>
                <tr>
                  <th>店舗名</th>
                  <th>商品コメント※最大140文字</th>
                </tr>
              </thead>
              @foreach($itemcomment as $itemcomment)
              <tbody>
                <tr>
                  <td> <input form="comment_form" type="hidden" class="form-control" name="store_id[]" value="{{ $itemcomment->pivot->store_id }}">{{ $itemcomment->store_name }}</td>
                  <td>
                    <div class="form-group">
                      <textarea form="comment_form" type="text" class="form-control" name="catch_copy[]" rows="3">{{ old('catch_copy[$i]', $itemcomment->pivot->catch_copy) }}</textarea>
                    </div>
                  </td>
                </tr>
              </tbody>
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
            <form id="comment_form" method="POST" action="{{ route('items.comment.update', $item->id) }}" enctype="multipart/form-data" class="h-adr inline_form">
              @csrf
              @method('PATCH')
              <button form="comment_form" type="submit" class="btn btn-primary" value="登録"><i class="fa fa-check-square"></i> @lang('item.comment.submit')</button>
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
      <h5>商品コメントの編集</h5>
      <hr class="mb-2">
      <p>この商品に対する店舗からのコメントを登録・編集可能です。各店舗ごとに設定が出来ます。</p>
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