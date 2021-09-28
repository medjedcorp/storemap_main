@extends('adminlte::page')

@section('title', 'お問い合わせ - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Storemapへのお問い合わせ</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">お問い合わせ</li>
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
                        <h3 class="card-title">お問い合わせ内容</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="post" action="{{ route('support.confirm') }}" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="cid" value="{{$cid}}">
                        <div class="card-body">
                            <p>利用方法についてのご質問は本フォームよりお問い合わせください。<br>
                                ツールの基本操作方法やよくある質問につきましては、マニュアルをご用意しております。ぜひご活用ください。</p>
                            <div class="form-group row">
                                <label for="inputCompany" class="col-sm-2 col-form-label">会社名</label>
                                <div class="col-sm-10">

                                    @if($errors->has('company'))
                                    <input type="text" class="form-control is-invalid" id="inputCompany" placeholder="{{$c_name}}" name="company" value="{{ old('company') }}" aria-describedby="company_code-error" aria-invalid="true">
                                    <span id="company_code-error" class="error invalid-feedback">{{$errors->first('company')}}</span>
                                    @else
                                    <input type="text" class="form-control" id="inputCompany" placeholder="{{$c_name}}" name="company" readonly value="{{$c_name}}">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">お名前</label>
                                <div class="col-sm-10">
                                    @if($errors->has('name'))
                                    <input type="text" class="form-control is-invalid" id="inputName" placeholder="お名前を入力してください" name="name" value="{{ old('name', isset($name) ? $name : '') }}" aria-describedby="name_code-error" aria-invalid="true">
                                    <span id="name_code-error" class="error invalid-feedback">{{$errors->first('name')}}</span>
                                    @else
                                    <input type="text" class="form-control" id="inputName" placeholder="お名前を入力してください" name="name" value="{{ old('name', isset($name) ? $name : '') }}">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">@lang('common.email')</label>
                                <div class="col-sm-10">
                                    @if($errors->has('email'))
                                    <input type="email" class="form-control is-invalid" name="email" id="inputEmail" placeholder="{{$email}}" value="{{ old('email', isset($email) ? $email : '') }}" aria-describedby="email_code-error" aria-invalid="true">
                                    <span id="email_code-error" class="error invalid-feedback">{{$errors->first('email')}}</span>
                                    @else
                                    <input type="email" class="form-control" id="inputEmail" placeholder="メールアドレスを入力してください" name="email" value="{{ old('email', isset($email) ? $email : '') }}">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">お問い合わせ内容</label>
                                <div class="col-sm-10">
                                    @if($errors->has('detail'))
                                    <textarea class="form-control is-invalid" id="inputText" name="detail" rows="5" aria-describedby="detail_code-error" aria-invalid="true">{{ old('detail', isset($detail) ? $detail : '') }}</textarea>
                                    <span id="detail_code-error" class="error invalid-feedback">{{$errors->first('detail')}}</span>
                                    @else
                                    <textarea class="form-control" id="inputText" name="detail" rows="5">{{ old('detail', isset($detail) ? $detail : '') }}</textarea>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="far fa-check-square"></i> 入力内容を確認</button>
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
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')

@stop