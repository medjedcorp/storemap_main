@extends('adminlte::page')

@section('title', 'ストアマップカテゴリ一括編集 - Storemap Cockpit')

@section('content_header')
<h1><i class="fas fa-user-secret"></i> @lang('system.smc.title')</h1>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-lg-6">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-download"></i> @lang('system.smc.download_card_title')</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <p>@lang('system.smc.download_title')</p>
            <form method="get" action="{{ action('SmCategoryCsvExportController@download') }}" class="h-adr" enctype="multipart/form-data">
              @csrf
              @method('get')
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
            <h3 class="card-title"><i class="fa fa-upload"></i> @lang('system.smc.update_card_title')</h3>
          </div>
          @include('partials.danger')
          @include('partials.success')
          <!-- /.card-header -->
          <div class="card-body">
            <p>@lang('system.smc.update_title')</p>
            <form method="post" action="{{ route('system.importSmCateCSV') }}" class="h-adr" enctype="multipart/form-data">
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
            <h3 class="card-title"><i class="far fa-question-circle"></i> @lang('system.smc.exp_card_title')</h3>
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
                  <th>@lang('system.smc.code_title')</th>
                  <td>@lang('system.smc.code')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('system.smc.code_exp')</td>
                  <td>@lang('csv.integer')</td>
                  <td>@lang('csv.integer_note')</td>
                </tr>
                <tr>
                  <th>@lang('system.smc.name_title')</th>
                  <td>@lang('system.smc.sm_name')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('system.smc.name_exp')</td>
                  <td>@lang('csv.string')(100)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('system.smc.parent_title')</th>
                  <td>@lang('system.smc.parent_id')</td>
                  <td>@lang('system.smc.parent_exp')</td>
                  <td>@lang('csv.integer')</td>
                  <td>@lang('system.smc.parent_note')</td>
                </tr>
              </tbody>
            </table>
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