@extends('adminlte::page')

@section('title', 'お問い合わせ - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">入力内容の確認</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/support">お問い合わせ</a></li>
                <li class="breadcrumb-item active">入力内容の確認確認</li>
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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">入力内容の確認</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('support.send') }}" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="cid" value="{{$inputs['cid'] }}">
                        <div class="card-body">
                            <p>利用方法についてのご質問は本フォームよりお問い合わせください。<br>
                                ツールの基本操作方法やよくある質問につきましては、マニュアルをご用意しております。ぜひご活用ください。</p>

                            <dl class="row">
                                <dt class="col-sm-2"><label for="inputCompany">会社名</label></dt>
                                <dd class="col-sm-10">{{ $inputs['company'] }}<input name="company" value="{{ $inputs['company'] }}" type="hidden" id="inputCompany"></dd>
                                <dt class="col-sm-2"><label for="inputName">@lang('common.name')</label></dt>
                                <dd class="col-sm-10">{{ $inputs['name'] }}<input name="name" value="{{ $inputs['name'] }}" type="hidden" id="inputName"></dd>
                                <dt class="col-sm-2"><label for="inputEmail">@lang('common.email')</label></dt>
                                <dd class="col-sm-10">{{ $inputs['email'] }}<input name="email" value="{{ $inputs['email'] }}" type="hidden" id="inputEmail"></dd>
                                <dt class="col-sm-2"><label for="inputDetail">@lang('common.mailbody')</label></dt>
                                <dd class="col-sm-10">{{ $inputs['detail'] }}<input name="detail" value="{{ $inputs['detail'] }}" type="hidden" id="inputDetail"></dd>
                            </dl>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" name="action" class="btn btn-primary" value="submit"><i class="far fa-paper-plane"></i> 入力内容を送信</button>
                            <button type="submit" name="action" class="btn btn-warning float-right" value="back"><i class="fas fa-edit"></i> 入力内容を修正</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
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
            {{-- <h5>お問い合わせ</h5>
            <hr class="mb-2">
            <p>お問い合わせください</p> --}}
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop