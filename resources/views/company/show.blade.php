@extends('adminlte::page')

@section('title', '会社情報の詳細 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">@lang('company.show.company_info')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">@lang('company.show.company_info')</li>
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

        <div class="card card-info card-outline">
          <div class="card-header">
            <h5 class="m-0"><i class="fas fa-building"></i> {{ $company->company_name }} の @lang('company.show.company_info')</h5>
          </div>
          <div class="card-body">
          @include('partials.success')
          @include('partials.warning')
            <p class="card-text">
              <dl class="row company-show">
                <dt class="col-sm-2 h6 card-title">@lang('company.register.c_name')</dt>
                <dd class="col-sm-10 h6 card-text">
                  {{ isset($company->company_name) ? $company->company_name : '※会社名を設定してください'}}</dd>

                @if (App::isLocale('ja')) {{-- 日本語のときだけ表示 --}}
                <dt class="col-sm-2 h6">会社名かな</dt>
                <dd class="col-sm-10 h6">{{ isset($company->company_kana) ? $company->company_kana : '' }}</dd>
                @endif

                <dt class="col-sm-2 h6">@lang('company.show.postcode')</dt>
                <dd class="col-sm-10 h6">
                  {{ isset($company->company_postcode) ? $company->company_postcode : '※郵便番号を設定してください'}}</dd>

                <dt class="col-sm-2 h6">@lang('company.show.address')</dt>
                @if(isset($company->prefecture,$company->company_city,$company->company_adnum))
                <dd class="col-sm-10 h6">
                  {{ $company->prefecture . $company->company_city . $company->company_adnum .' '. $company->company_apart }}
                </dd>
                @else
                <dd class="col-sm-10 h6">※住所に誤りがあります。</dd>
                @endif

                <dt class="col-sm-2 h6">@lang('company.show.company_p_number')</dt>
                <dd class="col-sm-10 h6">
                  {{ isset($company->company_phone_number) ? $company->company_phone_number : '※電話番号を設定してください' }}</dd>

                <dt class="col-sm-2 h6">@lang('company.show.company_f_number')</dt>
                <dd class="col-sm-10 h6">{{ isset($company->company_fax_number) ? $company->company_fax_number : '' }}</dd>

                <dt class="col-sm-2 h6">@lang('company.register.company_email')</dt>
                <dd class="col-sm-10 h6">{{ isset($company->company_email) ? $company->company_email : '' }}</dd>
                
                <dt class="col-sm-2 h6">@lang('company.register.manager_name')</dt>
                <dd class="col-sm-10 h6">{{ isset($company->manager_name) ? $company->manager_name : '※代表者名を設定してください'}}</dd>

                @if (App::isLocale('ja')) {{-- 日本語のときだけ表示 --}}
                <dt class="col-sm-2 h6">管理責任者名かな</dt>
                <dd class="col-sm-10 h6">{{ isset($company->manager_kana) ? $company->manager_kana : '' }}</dd>
                @endif

                <dt class="col-sm-2 h6">@lang('company.register.site_url')</dt>
                <dd class="col-sm-10 h6">{{ isset($company->site_url) ? $company->site_url : '' }}</dd>

                <dt class="col-sm-2 h6">公開設定</dt>
                @if( $company->display_flag == 0 )
                <dd class="col-sm-10 h6">非公開</dd>
                @elseif ( $company->display_flag == 1 )
                <dd class="col-sm-10 h6">公開中</dd>
                @else
                <dd class="col-sm-10 h6"></dd>
                @endif

                <dt class="col-sm-2 h6">@lang('company.register.maker_flag')</dt>
                @if( $company->maker_flag == 0 )
                <dd class="col-sm-10 h6">その他</dd>
                @elseif ( $company->maker_flag == 1 )
                <dd class="col-sm-10 h6">メーカー</dd>
                @else
                <dd class="col-sm-10 h6"></dd>
                @endif

                @if( $company->maker_flag == 1 )
                <dt class="col-sm-2 h6">@lang('company.edit.img_flag_title')</dt>
                @if( $company->img_flag == 0 )
                <dd class="col-sm-10 h6">他社画像利用不可</dd>
                @elseif ( $company->img_flag == 1 )
                <dd class="col-sm-10 h6">他社画像利用可</dd>
                @else
                <dd class="col-sm-10 h6"></dd>
                @endif

                <dt class="col-sm-2 h6">@lang('company.register.gs1_company_prefix')</dt>
                <dd class="col-sm-10 h6">{{ isset($company->gs1_company_prefix) ? $company->gs1_company_prefix : '' }}</dd>
                @endif

                <dt class="col-sm-2 h6">@lang('company.register.certificate')</dt>
                @if( $company->certificate )
                <dd class="col-sm-10 h6">※アップロード済み
                  @can('isSeller')
                  <div><a href="/company/download" class="btn btn-outline-success"><i class="fas fa-download"></i>
                      会社証明のダウンロード</a></div>
                  @else
                  <p class="small">管理者のみダウンロードが可能です</p>
                  @endcan
                  @else
                  <p class="small">アップロードされたデータはありません</p>
                  @endif
                </dd>
              </dl>
            </p>
            @can('isFree')
            <a href="{{ route('company.edit' , $company->id ) }}" class="btn btn-info"><i class="fas fa-edit"></i>
              会社情報を編集する</a>
            @endcan
          </div>
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
                <h5>会社情報</h5>
                <hr class="mb-2">
                <p>現在登録されている会社情報を閲覧できます。</p>
            </div>
        </div>
    </div>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop