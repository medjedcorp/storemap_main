@extends('adminlte::page')

@section('title', 'ユーザーの追加登録 - Storemap Cockpit')

@section('content_header')
<h1>@lang('user.register.title')</h1>
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
            <h3 class="card-title">@lang('user.register.card_title')</h3>
          </div>
          <!-- /.card-header -->
          @include('partials.errors')
          <!-- form start -->
          <div class="card-body">
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">@lang('user.register.name')
                @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('name'))
                <input form="user_form" type="text" class="form-control is-invalid" name="name" id="name" placeholder="@lang('user.register.name_pholder')" value="{{old('name')}}" aria-describedby="name-error" aria-invalid="true">
                <span id="name-error" class="error invalid-feedback">{{$errors->first('name')}}</span>
                @else
                <input form="user_form" type="text" class="form-control" id="name" name="name" placeholder="@lang('user.register.name_pholder')" value="{{old('name')}}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="user_form" class="col-sm-2 col-form-label">@lang('user.register.e_mail') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('email'))
                <input form="user_form" type="email" class="form-control is-invalid" name="email" id="email" placeholder="@lang('user.register.e_mail_pholder')" value="{{old('email')}}" aria-describedby="email-error" aria-invalid="true">
                <span id="email-error" class="error invalid-feedback">{{$errors->first('email')}}</span>
                @else
                <input form="user_form" type="email" class="form-control" id="email" name="email" placeholder="@lang('user.register.e_mail_pholder')" value="{{old('email')}}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="user_form" class="col-sm-2 col-form-label">@lang('user.register.password') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('password'))
                <input form="user_form" type="password" class="form-control is-invalid" name="password" id="password" value="{{old('password')}}" aria-describedby="password-error" aria-invalid="true">
                <span id="password-error" class="error invalid-feedback">{{$errors->first('password')}}</span>
                @else
                <input form="user_form" type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
                @endif
                <input type="checkbox" id="password-check" />パスワードを表示する
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('user.register.role') @include('partials.required') </label>
              <div class="col-sm-10">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-info">
                    <input form="user_form" type="radio" name="role" id="role1" value="seller" {{ old('role' , old('role')) == 'seller' ? 'checked' : '' }}>@lang('user.register.seller')
                  </label>
                  <label class="btn btn-outline-info">
                    <input form="user_form" type="radio" name="role" id="role0" value="staff" {{ old('role' , old('role')) == 'staff' ? 'checked' : '' }}>@lang('user.register.staff')
                  </label>
                </div>
                @if($errors->has('role'))
                <div class="small text-danger">{{$errors->first('role')}}</div>
                @endif
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <form id="user_form" method="POST" action="{{route('users.store')}}" enctype="multipart/form-data" class="h-adr inline_form">
              @csrf
              @method('POST')
              <input form="user_form" type="hidden" name="company_id" value="{{$company_id}}">
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i> @lang('user.register.submit')</button>
            </form>
            <button class="btn btn-default float-right" onclick="location.href='{{ route('users.index') }}'"><i class="fa fa-reply"></i> @lang('common.cancel')</button>
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

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{ asset('js/pass_view.js') }}"></script>
@stop