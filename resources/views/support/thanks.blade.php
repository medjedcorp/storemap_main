@extends('adminlte::page')

@section('title', 'お問い合わせを受け付けました - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">お問い合わせを受け付けました</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/support">お問い合わせ</a></li>
                <li class="breadcrumb-item active">受付完了</li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="far fa-paper-plane"></i> 送信完了</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        お問い合わせありがとうございました。
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a href="/home" class="btn btn-primary"><i class="fas fa-edit"></i> トップへ戻る</a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop