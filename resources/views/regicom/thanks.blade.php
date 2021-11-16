@extends('adminlte::top-page')

@section('title', 'ご登録ありがとうございます - StoreMap')

@section('content_header')
<h1 class="text-center mt-3">StoreMapの企業登録申請への受付完了</h1>
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
        <p>この度は、Storemapの企業登録にお申し込み頂きまして、誠にありがとうございます。
          入力いただいた情報をもとに登録審査を行なわせていただきます。
          審査の結果につきましては、２営業日以内にメールにてご案内いたしますので、
          お待ちくださいますようお願いいたします。</p>
      </div>

      <div class="col-12 mt-3 mb-5">
        <ul class="bootstrapWizard form-wizard">
          <li class="""> <span class=" step">1</span> <span class="title">必須項目を入力</span></li>
          <li class="active"> <span class="step">2</span> <span class="title">完了</span> </li>
        </ul>
      </div>

      <div class="col-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">受付内容</h3>
          </div>
          <!-- /.card-header -->

          <div class="card-body">
            <dl class="row">
              <dt class="col-sm-3"><label for="inputcompany_name">会社名</label></dt>
              <dd class="col-sm-9">{{ $inputs['company_name'] }}<input name="company_name" value="{{ $inputs['company_name'] }}" type="hidden" id="inputcompany_name"></dd>
              <dt class="col-sm-3"><label for="inputcompany_kana">会社名かな</label></dt>
              <dd class="col-sm-9">{{ $inputs['company_kana'] }}<input name="company_kana" value="{{ $inputs['company_kana'] }}" type="hidden" id="inputcompany_kana"></dd>
              <dt class="col-sm-3"><label for="inputcorporate_number">法人番号</label></dt>
              <dd class="col-sm-9">{{ $inputs['corporate_number'] }}<input name="corporate_number" value="{{ $inputs['corporate_number'] }}" type="hidden" id="inputcorporate_number"></dd>
              <dt class="col-sm-3"><label for="inputpresident_name">代表者名</label></dt>
              <dd class="col-sm-9">{{ $inputs['president_name'] }}<input name="president_name" value="{{ $inputs['president_name'] }}" type="hidden" id="inputpresident_name"></dd>
              <dt class="col-sm-3"><label for="inputcompany_postcode">郵便番号</label></dt>
              <dd class="col-sm-9">{{ $inputs['company_postcode'] }}<input name="company_postcode" value="{{ $inputs['company_postcode'] }}" type="hidden" id="inputcompany_postcode"></dd>
              <dt class="col-sm-3"><label for="inputprefecture">都道府県</label></dt>
              <dd class="col-sm-9">{{ $inputs['prefecture'] }}<input name="prefecture" value="{{ $inputs['prefecture'] }}" type="hidden" id="inputprefecture"></dd>
              <dt class="col-sm-3"><label for="inputcompany_city">市区町村</label></dt>
              <dd class="col-sm-9">{{ $inputs['company_city'] }}<input name="company_city" value="{{ $inputs['company_city'] }}" type="hidden" id="inputcompany_city"></dd>
              <dt class="col-sm-3"><label for="inputcompany_adnum">町名・番地</label></dt>
              <dd class="col-sm-9">{{ $inputs['company_adnum'] }}<input name="company_adnum" value="{{ $inputs['company_adnum'] }}" type="hidden" id="inputcompany_adnum"></dd>
              <dt class="col-sm-3"><label for="inputcompany_apart">ビル、マンション名</label></dt>
              <dd class="col-sm-9">{{ $inputs['company_apart'] }}<input name="company_apart" value="{{ $inputs['company_apart'] }}" type="hidden" id="inputcompany_apart"></dd>
              <dt class="col-sm-3"><label for="inputmanager_name">担当者名</label></dt>
              <dd class="col-sm-9">{{ $inputs['manager_name'] }}<input name="manager_name" value="{{ $inputs['manager_name'] }}" type="hidden" id="inputmanager_name"></dd>
              <dt class="col-sm-3"><label for="inputmanagertNameKana">担当者名かな</label></dt>
              <dd class="col-sm-9">{{ $inputs['manager_kana'] }}<input name="manager_kana" value="{{ $inputs['manager_kana'] }}" type="hidden" id="inputmanager_kana"></dd>
              <dt class="col-sm-3"><label for="inputcompany_email">メールアドレス</label></dt>
              <dd class="col-sm-9">{{ $inputs['company_email'] }}<input name="company_email" value="{{ $inputs['company_email'] }}" type="hidden" id="inputcompany_email"></dd>
              <dt class="col-sm-3"><label for="inputcompany_phone_number">担当者電話番号</label></dt>
              <dd class="col-sm-9">{{ $inputs['company_phone_number'] }}<input name="company_phone_number" value="{{ $inputs['company_phone_number'] }}" type="hidden" id="inputcompany_phone_number"></dd>
              <dt class="col-sm-3"><label for="inputcompany_fax_number">FAX</label></dt>
              <dd class="col-sm-9">{{ $inputs['company_fax_number'] }}<input name="managerFax" value="{{ $inputs['company_fax_number'] }}" type="hidden" id="inputcompany_fax_number"></dd>
              <dt class="col-sm-3"><label for="inputsite_url">サイトURL</label></dt>
              <dd class="col-sm-9">{{ $inputs['site_url'] }}<input name="site_url" value="{{ $inputs['site_url'] }}" type="hidden" id="inputsite_url"></dd>
            </dl>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            上記内容で受け付けました。ありがとうございました。
          </div>
        </div>
        <!-- /.card -->
      </div>

      <div class="col-12">
        @include('partials.footerlink')
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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/stepper.css') }}">
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop