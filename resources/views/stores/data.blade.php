@extends('adminlte::page')

@section('title', '店舗一括管理 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-7">
      <h1 class="m-0"><i class="fas fa-file-csv"></i> @lang('store.data.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-5">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/stores">店舗一覧</a></li>
        <li class="breadcrumb-item active">店舗一括管理</li>
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
      <div class="col-lg-6">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-download"></i> @lang('store.data.download_card_title')</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <p>@lang('store.data.download_title')</p>
            <form method="get" action="{{ action('StoreCsvExportController@download') }}" class="h-adr" enctype="multipart/form-data">
              @csrf
              @method('get')
              @can('isAdmin')
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">company_id @include('partials.required') </label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="company_id" name="company_id" placeholder="company_idを入力。セグメントして出力できます" value="{{ old('company_id') }}"><small class="text-red">※Adminのみの項目</small>
                </div>
              </div>
              @endcan
              <button type="submit" class="btn btn-block btn-info btn-lg"><i class="fa fa-download"></i> @lang('csv.download')</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-lg-6">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-upload"></i> @lang('store.data.upload_card_title')</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @include('partials.danger')
            @include('partials.success')
            <p>@lang('store.data.upload_title')<br>@lang('csv.upload_size')</p>
            <form method="post" action="{{ route('store.importStoreCSV') }}" class="h-adr" enctype="multipart/form-data">
              @csrf
              @method('post')
              @can('isAdmin')
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">company_id @include('partials.required')</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="company_id" name="company_id" placeholder="company_idを入力" value="{{ old('company_id') }}"><small class="text-red">※Adminのみの項目</small>
                </div>
              </div>
              @endcan
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name="file">
                <label class="custom-file-label" for="file">@lang('store.data.upload_label')</label>
              </div>
              <small id="fileHelp" class="form-text text-muted mb-2">@lang('store.data.upload_small')</small>
              <br>
              <button type="submit" class="btn btn-block btn-primary btn-lg"><i class="fa fa-upload"></i> @lang('csv.upload')</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- right column -->
      <div class="col-lg-12">
        <div class="card card-outline card-warning">
          <div class="card-header">
            <h3 class="card-title"><i class="far fa-question-circle"></i> @lang('csv.store.card_title')</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <ul>
              <li>@lang('csv.li1')</li>
              <li>@lang('csv.li2')</li>
              <li>@lang('csv.li3')<br>@lang('csv.li4')</li>
              <li>@lang('csv.li5')</li>
            </ul>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-nowrap">@lang('csv.name')</th>
                  <th>@lang('csv.csv_name')</th>
                  <th>@lang('csv.explanation')</th>
                  <th class="text-nowrap">@lang('csv.limit')</th>
                  <th style="width:25%">@lang('csv.note')</th>
                </tr>
              </thead>
              <tbody>
                @can('isAdmin')
                <tr>
                  <th>company_id</th>
                  <td>company_id</td>
                  <td><span class="text-danger">@lang('csv.required') 管理者(admin)のみの項目</span><br>company_idを指定することで、対象企業の情報を更新できます。バリデーションしてません</td>
                  <td>数値のみ</td>
                  <td><span class="text-danger">※取扱注意</span></td>
                </tr>
                @endcan
                <tr>
                  <th>@lang('csv.store.code')</th>
                  <td>@lang('csv.store.store_code')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.code_exp')</td>
                  <td>@lang('csv.string')(20)</td>
                  <td>@lang('csv.store.code_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.store.name')</th>
                  <td>@lang('csv.store.store_name')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_name_exp')</td>
                  <td>@lang('csv.string')(85)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.kana')</th>
                  <td>@lang('csv.store.store_kana')</td>
                  <td>@lang('csv.store.store_kana_exp')</td>
                  <td>@lang('csv.string')(85)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.postcode')</th>
                  <td>@lang('csv.store.store_postcode')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_postcode_exp')</td>
                  <td>@lang('csv.jpzip')</td>
                  <td>@lang('csv.store.store_postcode_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.store.pre')</th>
                  <td>@lang('csv.store.prefecture')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.prefecture_exp')</td>
                  <td>@lang('csv.string')(4)</td>
                  <td>@lang('csv.store.prefecture_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.store.city')</th>
                  <td>@lang('csv.store.store_city')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_city_exp')</td>
                  <td>@lang('csv.string')(30)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.adnum')</th>
                  <td>@lang('csv.store.store_adnum')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_adnum_exp')</td>
                  <td>@lang('csv.string')(50)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.apart')</th>
                  <td>@lang('csv.store.store_apart')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_apart_exp')</td>
                  <td>@lang('csv.string')(100)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.phone_number')</th>
                  <td>@lang('csv.store.store_phone_number')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_phone_number_exp')</td>
                  <td>@lang('csv.tel')</td>
                  <td>@lang('csv.store.store_phone_number_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.store.fax_number')</th>
                  <td>@lang('csv.store.store_fax_number')</td>
                  <td>@lang('csv.store.store_fax_number_exp')</td>
                  <td>@lang('csv.tel')</td>
                  <td>@lang('csv.store.store_fax_number_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.store.email')</th>
                  <td>@lang('csv.store.store_email')</td>
                  <td>@lang('csv.store.store_email_exp')</td>
                  <td>@lang('csv.email')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.flag')</th>
                  <td>@lang('csv.store.pause_flag')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.pause_flag')</td>
                  <td>@lang('csv.bool_0')<br>@lang('csv.bool_1')</td>
                  <td>@lang('csv.store.pause_flag_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.store.img1')</th>
                  <td>@lang('csv.store.store_img1')</td>
                  <td>@lang('csv.store.store_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.img2')</th>
                  <td>@lang('csv.store.store_img2')</td>
                  <td>@lang('csv.store.store_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.img3')</th>
                  <td>@lang('csv.store.store_img3')</td>
                  <td>@lang('csv.store.store_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.img4')</th>
                  <td>@lang('csv.store.store_img4')</td>
                  <td>@lang('csv.store.store_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.img5')</th>
                  <td>@lang('csv.store.store_img5')</td>
                  <td>@lang('csv.store.store_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.info')</th>
                  <td>@lang('csv.store.store_info')</td>
                  <td>@lang('csv.store.store_info_exp')</td>
                  <td>@lang('csv.string')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.industry')</th>
                  <td>@lang('csv.store.industry_id')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.industry_id_exp')</td>
                  <td>@lang('csv.num')</td>
                  <td>@lang('csv.store.industry_id_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.store.url')</th>
                  <td>@lang('csv.store.store_url')</td>
                  <td>@lang('csv.store.store_url_exp')</td>
                  <td>@lang('csv.url')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.flyer')</th>
                  <td>@lang('csv.store.flyer_img')</td>
                  <td>@lang('csv.store.flyer_img_exp')</td>
                  <td>@lang('csv.url')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.store.floor')</th>
                  <td>@lang('csv.store.floor_guide')</td>
                  <td>@lang('csv.store.floor_guide_exp')</td>
                  <td>@lang('csv.url')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('store.pay_info')</th>
                  <td>@lang('csv.store.pay_info')</td>
                  <td>@lang('csv.store.pay_info_exp')</td>
                  <td>@lang('csv.string')[500]</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('store.access')</th>
                  <td>@lang('csv.store.access')</td>
                  <td>@lang('csv.store.access_exp')</td>
                  <td>@lang('csv.string')[255]</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('store.opening_hour')</th>
                  <td>@lang('csv.store.opening_hour')</td>
                  <td>@lang('csv.store.opening_hour_exp')</td>
                  <td>@lang('csv.string')[255]</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('store.closed_day')</th>
                  <td>@lang('csv.store.closed_day')</td>
                  <td>@lang('csv.store.closed_day_exp')</td>
                  <td>@lang('csv.string')[255]</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('store.parking')</th>
                  <td>@lang('csv.store.parking')</td>
                  <td>@lang('csv.store.parking_exp')</td>
                  <td>@lang('csv.string')[255]</td>
                  <td></td>
                </tr>
              </tbody>
            </table>
            <div class="mt-4 mb-5">
              <form method="get" action="{{ action('StoreCsvExportController@StoreTempFileDownload') }}" class="h-adr" enctype="multipart/form-data">
                @csrf
                @method('get')
                <button type="submit" class="btn btn-warning"><i class="fas fa-file-download"></i> @lang('csv.template')</button>
              </form>
            </div>
          </div>
          <!-- /.card-body -->
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
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init()
  })
</script>
@stop