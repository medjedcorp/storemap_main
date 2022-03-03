@extends('adminlte::page')

@section('title', 'ユーザー詳細設定 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-7">
      <h1 class="m-0">@lang('user.edit.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-5">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/users">@lang('user.index.title')</a></li>
        <li class="breadcrumb-item active">ユーザー情報の編集</li>
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
            <h3 class="card-title"><i class="fas fa-user-edit"></i> @lang('user.edit.card_title')</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
          @include('partials.success')
          @include('partials.errors')
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">@lang('user.register.name') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('name'))
                <input form="user_form" type="text" class="form-control is-invalid" name="name" id="name" placeholder="@lang('user.register.name_pholder')" value="{{ old('name', $user->name ) }}" aria-describedby="name-error" aria-invalid="true">
                <span id="name-error" class="error invalid-feedback">{{$errors->first('name')}}</span>
                @else
                <input form="user_form" type="text" class="form-control" id="name" name="name" placeholder="@lang('user.register.name_pholder')" value="{{ old('name', $user->name ) }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="user_form" class="col-sm-2 col-form-label">@lang('user.edit.e_mail')</label>
              <div class="col-sm-10">
                <input form="user_form" type="email" class="form-control" id="email" name="email" value="{{old('email', $user->email )}}" disabled>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('user.register.role') @include('partials.required') </label>
              <div class="col-sm-10">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-info">
                    <input form="user_form" type="radio" name="role" id="role1" value="seller" {{ old( 'role' , $user->role) == 'seller' ? 'checked' : '' }}>@lang('user.register.seller')
                  </label>
                  <label class="btn btn-outline-info">
                    <input form="user_form" type="radio" name="role" id="role0" value="staff" {{ old( 'role' , $user->role) == 'staff' ? 'checked' : '' }}>@lang('user.register.staff')
                  </label>
                </div>
                @if($errors->has('role'))
                <div class="small text-danger">{{$errors->first('role')}}</div>
                @endif
              </div>
            </div>
            <hr class="mb-5">

            <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-house-user"></i> 担当店舗設定</h3>
              </div>

              <div class="card-body">
                @foreach ($sid as $sid)
                <div class="form-group row">
                  <div class="col-sm-2">
                    <input form="user_form" type="checkbox" data-on-color="success" name="store_id[]" id="customCheck{{($sid->id)}}" value="{{($sid->id)}}" @foreach ($user->store as $store)
                    {{ old('$sid' , $store->id) == $sid->id ? 'checked' : '' }}
                    @endforeach
                    >
                  </div>
                  <div class="col-sm-10">
                    <label for="customCheck{{($sid->id)}}">{{($sid->store_name)}}</label>
                  </div>

                </div>
                @endforeach
                @foreach ($errors->get('store_id.*') as $message)
                <div class="small text-danger">※{{$errors->first('store_id.*')}}</div>
                @endforeach
              </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <form id="user_form" method="POST" action="{{route('users.update',  $user->id )}}" enctype="multipart/form-data" class="h-adr inline_form">
                @csrf
                @method('PATCH')
                <input form="user_form" type="hidden" name="company_id" value="{{ $company_id }}">
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i> @lang('user.edit.submit')</button>
              </form>
              <button class="btn btn-default float-right" onclick="location.href='{{ route('users.index') }}'"><i class="fa fa-reply"></i> @lang('common.back')</button>
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
<div class="footer-area">
  <div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
  {!! config('const.manage.footer') !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap-switch.min.js') }}"></script>
<script>
  $("[name='store_id[]']").bootstrapSwitch();
</script>
@stop