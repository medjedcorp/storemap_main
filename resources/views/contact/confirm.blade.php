@extends('adminlte::top-page')

@section('title', 'お問い合わせ内容の確認 - Storemap')

@section('content_header')
<h1><i class="far fa-envelope"></i> ストアマップへのお問い合わせ</h1>
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

      <div class="col-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="far fa-check-square"></i> お問い合わせ内容の確認</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form method="post" action="{{ route('contact.send') }}" enctype="multipart/form-data" class="inline_form">
            @csrf
            @method('post')
            <div class="card-body">
              <dl class="row">
                <dt class="col-sm-3"><label for="inputEmail">@lang('common.email')</label></dt>
                <dd class="col-sm-9">{{ $inputs['email'] }}<input name="email" value="{{ $inputs['email'] }}" type="hidden" id="inputEmail"></dd>
                <dt class="col-sm-3"><label for="inputTitle">@lang('common.title')</label></dt>
                <dd class="col-sm-9">{{ $inputs['title'] }}<input name="title" value="{{ $inputs['title'] }}" type="hidden" id="inputTitle"></dd>
                <dt class="col-sm-3"><label for="inputBody">@lang('common.mailbody')</label></dt>
                <dd class="col-sm-9">{{ $inputs['body'] }}<input name="body" value="{{ $inputs['body'] }}" type="hidden" id="inputBody"></dd>
              </dl>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" name="action" class="btn btn-warning" value="back"><i class="fas fa-edit"></i> 入力内容を修正</button>
              <button type="submit" name="action" class="btn btn-primary" value="submit"><i class="far fa-paper-plane"></i> 入力内容を送信</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
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