@extends('adminlte::page')

@section('title', 'Storemap Cockpit：受信用API設定')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">受信用API設定</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">受信用API設定</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-outline card-primary">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-handshake mr-1"></i>
              受信設定
            </h3>
          </div>

          @include('partials.success')
          @include('partials.danger')

          <div class="card-body">
            <div class="row">
              <p class="col-sm-4">契約ID</p>
              <p class="col-sm-8">{{$company_code}}</p>
              <p class="col-sm-4">アクセストークン</p>
              <div class="col-sm-8">
                @if($api_token) {{$api_token}}
                <form id="generate_form" method="POST" action="{{route('sm.apiDel')}}" enctype="multipart/form-data" class="d-inline-block ml-2">
                  @csrf
                  @method('POST')
                  <button form="generate_form" type="submit" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i> アクセストークン削除</button>
                </form>
                @else
                <form id="generate_form" method="POST" action="{{route('sm.generate')}}" enctype="multipart/form-data" class="d-inline-block">
                  @csrf
                  @method('POST')
                  <button form="generate_form" type="submit" class="btn btn-info"><i class="fas fa-key"></i> アクセストークン作成</button>
                </form>
                @endif
              </div>
              <p class="col-sm-4">受信用URL</p>
              <p class="col-sm-8">https://storemap.jp/受信用URL</p>
              <div class="col-12">
                <form id="flag_form" method="POST" action="{{route('sm.useApi')}}" enctype="multipart/form-data" class="row">
                  @csrf
                  @method('POST')
                  <div class="col-sm-4">受信機能を利用する</div>
                  <div class="col-sm-8">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label class="btn btn-outline-info active">
                        <input form="flag_form" type="radio" name="api_flag" id="api_flag0" value="0" {{ old('api_flg' , $api_flag ) == '0' ? 'checked' : '' }}>利用しない </label>
                      <label class="btn btn-outline-info">
                        <input form="flag_form" type="radio" name="api_flag" id="api_flag1" value="1" {{ old('api_flg' , $api_flag ) == '1' ? 'checked' : '' }}>利用する </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i> 更新</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!-- /.card-body -->
      </div>
    </div>
  </div>
</section>
@stop

@section('right-sidebar')
<div class="os-padding text-sm">
  <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
    <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">

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
@stop

@section('js')
<script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init()
  })
</script>
@stop