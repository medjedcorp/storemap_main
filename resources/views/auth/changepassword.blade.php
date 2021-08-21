@extends('adminlte::page')

@section('title', 'ユーザーパスワードの変更')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0"><i class="fas fa-user-lock"></i> @lang('user.pass.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">@lang('user.pass.title')</li>
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
      <div class="col-lg-7">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title"> @lang('user.pass.card_title')</h3>
          </div>
          @include('partials.danger')
          @include('partials.warning')
          @include('partials.success')
          <!-- /.card-header -->
          <div class="card-body">
            <form method="POST" action="{{route('changepassword')}}">
              @csrf
              <div class="form-group">
                <label for="current">
                  @lang('user.pass.now_pass')
                </label>
                <div>
                  <input id="current" type="password" class="form-control" name="current-password" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="password">
                  @lang('user.pass.new_pass')
                </label>
                <div>
                  <input id="password" type="password" class="form-control" name="new-password" required>
                  @if ($errors->has('new-password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('new-password') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="confirm">
                  @lang('user.pass.confirm')
                </label>
                <div>
                  <input id="confirm" type="password" class="form-control" name="new-password_confirmation" required>
                </div>
              </div>
              <div>
                <button type="submit" class="btn btn-primary">@lang('common.change')</button>
              </div>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')

@stop