@extends('adminlte::top-page')

@section('title', 'お問い合わせありがとうございました - Storemap')

@section('content_header')

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
            <h3 class="card-title"><i class="far fa-paper-plane"></i> 送信完了</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            お問い合わせありがとうございました。
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <a href="/" class="btn btn-primary"><i class="fas fa-edit"></i> トップへ戻る</a>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.row -->
    </div>
  </div><!-- /.container-fluid -->
</section>

@stop

@section('footer')
@include('partials.footerlink')
@stop

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
<link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop