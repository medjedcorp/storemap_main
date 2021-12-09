@extends('adminlte::page')

@section('title', 'カタログ一括出品 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0"><i class="fas fa-file-csv"></i> @lang('catalog.data.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">@lang('catalog.data.title')</li>
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
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-upload"></i> @lang('catalog.data.upload_card_title')</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @include('partials.danger')
            @include('partials.success')
            <p>@lang('catalog.data.upload_title')</p>
            <form method="post" action="{{ route('catalog.importCSV') }}" class="h-adr" enctype="multipart/form-data">
              @csrf
              @method('post')
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name="file">
                <label class="custom-file-label" for="file">@lang('csv.upload_label')</label>
              </div>
              <small id="fileHelp" class="form-text text-muted mb-2">@lang('csv.upload_small')</small>
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
            <h3 class="card-title"><i class="far fa-question-circle"></i> @lang('csv.catalog.card_title')</h3>
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
                <tr>
                  <th>@lang('csv.catalog.barcode_title')</th>
                  <td>@lang('csv.catalog.barcode')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.catalog.barcode_exp')</td>
                  <td>@lang('csv.string')(20)</td>
                  <td>@lang('csv.catalog.barcode_note')</td>
                </tr>
              </tbody>
            </table>
            <div class="mt-4 mb-5">
              <form method="get" action="{{ action('CatalogController@CatalogTempFileDownload') }}" class="h-adr" enctype="multipart/form-data">
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