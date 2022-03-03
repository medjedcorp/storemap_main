@extends('adminlte::top-page')

@section('title', 'ストアマップへのお問い合わせ - Storemap')

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
            <h3 class="card-title">お問い合わせ内容</h3>
          </div>
        
          <!-- /.card-header -->
          <!-- form start -->
          <form method="post" action="{{ route('contact.confirm') }}" enctype="multipart/form-data" class="inline_form">
            @csrf
            <div class="card-body">
            @include('partials.errors')
              <div class="form-group">
                <label for="inputEmail">@lang('common.email')</label>
                @if($errors->has('email'))
                <input type="email" class="form-control is-invalid" name="email" id="inputEmail" placeholder="メールアドレスを入力してください" value="{{old('email')}}" aria-describedby="email_code-error" aria-invalid="true">
                <span id="email_code-error" class="error invalid-feedback">{{$errors->first('email')}}</span>
                @else
                <input type="email" class="form-control" id="inputEmail" placeholder="メールアドレスを入力してください" name="email" value="{{ old('email') }}">
                @endif
              </div>
              <div class="form-group">
                <label for="inputName">@lang('common.name')</label>
                @if($errors->has('name'))
                <input type="text" class="form-control is-invalid" name="name" id="inputName" placeholder="お名前を入力してください" value="{{old('name')}}" aria-describedby="name_code-error" aria-invalid="true">
                <span id="name_code-error" class="error invalid-feedback">{{$errors->first('name')}}</span>
                @else
                <input type="text" class="form-control" id="inputName" placeholder="お名前を入力してください" name="name" value="{{ old('name') }}">
                @endif
              </div>
              <div class="form-group">
                <label for="inputBody">@lang('common.mailbody')</label>
                @if($errors->has('body'))
                <textarea class="form-control is-invalid" rows="3" id="inputBody" placeholder="お問い合わせ内容を入力してください" name="body" aria-describedby="body_code-error" aria-invalid="true">{{ old('body') }}</textarea>
                <span id="body_code-error" class="error invalid-feedback">{{$errors->first('body')}}</span>
                @else
                <textarea class="form-control" rows="3" id="inputBody" placeholder="お問い合わせ内容を入力してください" name="body">{{ old('body') }}</textarea>
                @endif
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="far fa-check-square"></i> 入力内容を確認</button>
            </div>
          </form>
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