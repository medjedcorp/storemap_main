@extends('adminlte::page')

@section('title', 'カテゴリの登録 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">@lang('category.register.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/categories">カテゴリ一覧</a></li>
        <li class="breadcrumb-item active">@lang('category.register.title')</li>
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
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">@lang('category.register.card_title')</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            @include('partials.errors')
            @include('partials.success')
            <div class="form-group row">
              <label for="category_code" class="col-sm-2 col-form-label">@lang('category.register.cate_code') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('category_code'))
                <input form="category_form" type="text" class="form-control is-invalid" name="category_code" id="category_code" placeholder="@lang('category.register.cate_code_pholder')" value="{{old('category_code')}}" aria-describedby="category_code-error" aria-invalid="true">
                <span id="category_code-error" class="error invalid-feedback">{{$errors->first('category_code')}}</span>
                @else
                <input form="category_form" type="text" class="form-control" id="category_code" name="category_code" placeholder="@lang('category.register.cate_code_pholder')" value="{{old('category_code')}}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="category_name" class="col-sm-2 col-form-label">@lang('category.register.cate_name') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('category_name'))
                <input form="category_form" type="text" class="form-control is-invalid" name="category_name" id="category_name" placeholder="@lang('category.register.cate_name_pholder')" value="{{old('category_name')}}" aria-describedby="category_name-error" aria-invalid="true">
                <span id="category_name-error" class="error invalid-feedback">{{$errors->first('category_name')}}</span>
                @else
                <input form="category_form" type="text" class="form-control" id="category_name" name="category_name" placeholder="@lang('category.register.cate_name_pholder')" value="{{old('category_name')}}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('category.register.display_flag') @include('partials.required') </label>
              <div class="col-sm-10">
                @if($errors->has('display_flag'))
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-info">
                    <input form="category_form" type="radio" name="display_flag" id="display_flag1" value="1" {{ old('display_flag' , old('display_flag')) == '1' ? 'checked' : '' }}>@lang('category.register.show')
                  </label>
                  <label class="btn btn-outline-info">
                    <input form="category_form" type="radio" name="display_flag" id="display_flag0" value="0" {{ old('display_flag' , old('display_flag')) == '0' ? 'checked' : '' }}>@lang('category.register.hide')
                  </label>
                </div>
                <div class="small text-danger">{{$errors->first('display_flag')}}</div>
                @elseif(count($errors) > 0)
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-info">
                    <input form="category_form" type="radio" name="display_flag" id="display_flag1" value="1" {{ old('display_flag' , old('display_flag')) == '1' ? 'checked' : '' }}>@lang('category.register.show')
                  </label>
                  <label class="btn btn-outline-info">
                    <input form="category_form" type="radio" name="display_flag" id="display_flag0" value="0" {{ old('display_flag' , old('display_flag')) == '0' ? 'checked' : '' }}>@lang('category.register.hide')
                  </label>
                </div>
                @else
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-info">
                    <input form="category_form" type="radio" name="display_flag" id="display_flag1" value="1" checked>@lang('category.register.show')
                  </label>
                  <label class="btn btn-outline-info">
                    <input form="category_form" type="radio" name="display_flag" id="display_flag0" value="0">@lang('category.register.hide')
                  </label>
                </div>
                @endif
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <form id="category_form" method="POST" action="{{route('categories.store')}}" enctype="multipart/form-data" class="h-adr inline_form">
              @csrf
              @method('POST')
              <input id="category_form" type="hidden" name="company_id" value="{{$company_id}}">
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i> @lang('category.register.submit')</button>
            </form>
            <button class="btn btn-default float-right" onclick="location.href='{{ route('categories.index') }}'"><i class="fa fa-reply"></i> @lang('common.cancel')</button>
          </div>
          <!-- /.card-footer -->

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
      <h5>商品カテゴリの登録</h5>
      <hr class="mb-2">
      <p>商品カテゴリの登録ができます。</p>
      <dl>
        <dt>カテゴリコード </dt>
        <dd>カテゴリコードを入力してください。半角英数とハイフン(-)のみ利用可能です。</dd>
        <dt>カテゴリ名</dt>
        <dd>カテゴリ名を入力してください。</dd>
        <dt>表示設定</dt>
        <dd>カテゴリごとに「表示」か「非表示」を設定できます。非表示を選択した場合、店舗画面でカテゴリが非表示になります。</dd>
      </dl>
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