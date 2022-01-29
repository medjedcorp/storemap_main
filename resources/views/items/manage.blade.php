@extends('adminlte::page')

@section('title', '販売情報一括管理 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0"><i class="fas fa-file-csv"></i> @lang('item.manage.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/items">商品一覧</a></li>
        <li class="breadcrumb-item active">販売情報一括管理</li>
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
            <h3 class="card-title"><i class="fa fa-download"></i> @lang('item.manage.download_card_title')</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <p>@lang('item.manage.download_title')</p>
            <form method="get" action="{{ action('ItemStoreCsvExportController@download') }}" class="h-adr" enctype="multipart/form-data">
              @csrf
              @method('get')
              @can('isAdmin')
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">company_id @include('partials.required') <small class="text-red">※Adminのみの項目</small></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="company_id" name="company_id" placeholder="company_idを入力。セグメントして出力できます" value="{{ old('company_id') }}">
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
            <h3 class="card-title"><i class="fa fa-upload"></i> @lang('item.manage.upload_card_title')</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          @include('partials.danger')
          @include('partials.success')
            <p>@lang('item.manage.upload_title')<br>@lang('csv.upload_size')</p>
            <form method="post" action="{{ route('IS.importISCSV') }}" class="h-adr" enctype="multipart/form-data">
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
                <label class="custom-file-label" for="file">@lang('item.manage.upload_label')</label>
              </div>
              <small id="fileHelp" class="form-text text-muted mb-2">@lang('item.manage.upload_small')</small>
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
            <h3 class="card-title"><i class="far fa-question-circle"></i> @lang('csv.manage.card_title')</h3>
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
                  <th>@lang('csv.name')</th>
                  <th>@lang('csv.csv_name')</th>
                  <th>@lang('csv.explanation')</th>
                  <th class="text-nowrap">@lang('csv.limit')</th>
                  <th>@lang('csv.note')</th>
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
                  <th>@lang('csv.item.code')</th>
                  <td>@lang('csv.item.product_code')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.product_code_exp')</td>
                  <td>@lang('csv.string')(40)</td>
                  <td>@lang('csv.item.code_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.store.code')</th>
                  <td>@lang('csv.store.store_code')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.store_code_exp')</td>
                  <td>@lang('csv.string')(20)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.p_type')</th>
                  <td>@lang('csv.manage.price_type')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.price_type_exp')</td>
                  <td>@lang('csv.manage.price_type_0')<br>@lang('csv.manage.price_type_1')<br>@lang('csv.manage.price_type_2')</td>
                  <td>@lang('csv.manage.price_type_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.price_title')</th>
                  <td>@lang('csv.manage.price')</td>
                  <td>@lang('csv.manage.price_exp')</td>
                  <td>@lang('csv.num')(10)</td>
                  <td>@lang('csv.manage.price_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.value_title')</th>
                  <td>@lang('csv.manage.value')</td>
                  <td>@lang('csv.manage.value_exp')</td>
                  <td>@lang('csv.num')(10)</td>
                  <td>@lang('csv.manage.value_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.start_date_title')</th>
                  <td>@lang('csv.manage.start_date')</td>
                  <td>@lang('csv.manage.start_date_exp')</td>
                  <td>@lang('csv.date_time')</td>
                  <td>@lang('csv.manage.start_date_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.end_date_title')</th>
                  <td>@lang('csv.manage.end_date')</td>
                  <td>@lang('csv.manage.end_date_exp')</td>
                  <td>@lang('csv.date_time')</td>
                  <td>@lang('csv.manage.end_date_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.sort_num_title')</th>
                  <td>@lang('csv.manage.sort_num')</td>
                  <td>@lang('csv.manage.sort_num_exp')</td>
                  <td>@lang('csv.num')(10)</td>
                  <td>@lang('csv.manage.sort_num_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.stock_amount_title')</th>
                  <td>@lang('csv.manage.stock_amount')</td>
                  <td>@lang('csv.manage.stock_amount_exp')</td>
                  <td>@lang('csv.num')(8)</td>
                  <td>@lang('csv.manage.stock_amount_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.stock_set_title')</th>
                  <td>@lang('csv.manage.stock_set')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.stock_set_exp')</td>
                  <td>@lang('csv.manage.stock_set0')<br>@lang('csv.manage.stock_set1')</td>
                  <td>@lang('csv.manage.stock_set_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.catch_copy_title')</th>
                  <td>@lang('csv.manage.catch_copy')</td>
                  <td>@lang('csv.manage.catch_copy_exp')</td>
                  <td>@lang('csv.string')(140)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.shelf_number_title')</th>
                  <td>@lang('csv.manage.shelf_number')</td>
                  <td>@lang('csv.manage.shelf_number_exp')</td>
                  <td>@lang('csv.string')(10)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.manage.selling_flag_title')</th>
                  <td>@lang('csv.manage.selling_flag')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.selling_flag_exp')</td>
                  <td>@lang('csv.manage.selling_flag0')<br>@lang('csv.manage.selling_flag1')</td>
                  <td></td>
                </tr>
              </tbody>
            </table>
            <div class="mt-4 mb-5">
              <form method="get" action="{{ action('ItemStoreCsvExportController@ItemStoreTempFileDownload') }}" class="h-adr" enctype="multipart/form-data">
                @csrf
                @method('get')
                <button type="submit" class="btn btn-warning"><i class="fas fa-file-download"></i> @lang('csv.template')</button>
            </div>
            </form>
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
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
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