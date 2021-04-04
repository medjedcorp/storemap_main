@extends('adminlte::top-page')

@section('title', 'Storemap：ストアマップ / 運営会社情報')

@section('content_header')
<h1>ストアマップ / 運営会社情報</h1>
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
      <!-- left column -->
      <div class="col-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
              <i class="far fa-building"></i>
              会社概要
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <dl class="row">
              <dt class="col-sm-3">商号</dt>
              <dd class="col-sm-9">メジェド合同会社</dd>
              <dt class="col-sm-3">設立</dt>
              <dd class="col-sm-9">2020年(令和２年)10月20日</dd>
              {{-- <dd class="col-sm-8 offset-sm-4"></dd> --}}
              <dt class="col-sm-3">資本金</dt>
              <dd class="col-sm-9">300,000円</dd>
              <dt class="col-sm-3">代表者</dt>
              <dd class="col-sm-9">松田 智哉</dd>
              <dt class="col-sm-3">電話番号</dt>
              <dd class="col-sm-9">050-3590-0017</dd>
              <dt class="col-sm-3">事業内容</dt>
              <dd class="col-sm-9">インターネットを利用した情報提供サービス</dd>
            </dl>
          </div>
          <!-- /.card-body -->
        </div>

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