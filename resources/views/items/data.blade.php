@extends('adminlte::page')

@section('title', '商品情報一括管理 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0"><i class="fas fa-file-csv"></i> @lang('item.data.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/items">商品一覧</a></li>
        <li class="breadcrumb-item active">商品一括管理</li>
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
            <h3 class="card-title"><i class="fa fa-download"></i> @lang('item.data.download_card_title')</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <p>@lang('item.data.download_title')</p>
            <form method="get" action="{{ action('ItemCsvExportController@download') }}" class="h-adr" enctype="multipart/form-data">
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
            <h3 class="card-title"><i class="fa fa-upload"></i> @lang('item.data.upload_card_title')</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          @include('partials.danger')
          @include('partials.success')
            <p>@lang('item.data.upload_title')<br>@lang('csv.upload_size')</p>
            <form method="post" action="{{ route('item.importItemCSV') }}" class="h-adr" enctype="multipart/form-data">
              @csrf
              @method('post')
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name="file">
                <label class="custom-file-label" for="file">@lang('item.data.upload_label')</label>
              </div>
              <small id="fileHelp" class="form-text text-muted mb-2">@lang('item.data.upload_small')</small>
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
            <h3 class="card-title"><i class="far fa-question-circle"></i> @lang('csv.item.card_title')</h3>
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
                  <th>@lang('csv.item.code')</th>
                  <td>@lang('csv.item.product_code')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.item.code_exp')</td>
                  <td>@lang('csv.string')(40)</td>
                  <td>@lang('csv.item.code_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.name')</th>
                  <td>@lang('csv.item.product_name')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.item.product_name_exp')</td>
                  <td>@lang('csv.string')(255)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.item.brand')</th>
                  <td>@lang('csv.item.brand_name')</td>
                  <td>@lang('csv.item.brand_exp')</td>
                  <td>@lang('csv.string')(100)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.item.bar')</th>
                  <td>@lang('csv.item.barcode')</td>
                  <td>@lang('csv.item.barcode_exp')</td>
                  <td>@lang('csv.string')(20)</td>
                  <td>@lang('csv.item.barcode_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.category.code')</th>
                  <td>@lang('csv.category.category_code')</td>
                  <td>カテゴリ管理で作成した、カテゴリコードを入力</td>
                  <td>@lang('csv.string')(30)</td>
                  <td>@lang('csv.category.code_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.o_price')</th>
                  <td>@lang('csv.item.original_price')</td>
                  <td>@lang('csv.item.original_price_exp')</td>
                  <td>@lang('csv.num')(10)</td>
                  <td>@lang('csv.item.original_price_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.flag')</th>
                  <td>@lang('csv.item.display_flag')</td>
                  <td>@lang('csv.item.display_flag_exp')</td>
                  <td>@lang('csv.bool_0')<br>@lang('csv.bool_1')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>カラーID</th>
                  <td>color_id</td>
                  <td>数値を入力。商品の近似色から選択してください。
                    <ul>
                      <li><span style="color: #ffffff"><i class="fas fa-square"></i></span> 1:ホワイト系</li>
                      <li><span style="color: #000000"><i class="fas fa-square"></i></span> 2:ブラック系</li>
                      <li><span style="color: #808080"><i class="fas fa-square"></i></span> 3:グレー系</li>
                      <li><span style="color: #A52A2A"><i class="fas fa-square"></i></span> 4:ブラウン系</li>
                      <li><span style="color: #9a753a"><i class="fas fa-square"></i></span> 5:カーキ系</li>
                      <li><span style="color: #F5F5DC"><i class="fas fa-square"></i></span> 6:ベージュ系</li>
                      <li><span style="color: #00FF00"><i class="fas fa-square"></i></span> 7:ライム系</li>
                      <li><span style="color: #008000"><i class="fas fa-square"></i></span> 8:グリーン系</li>
                      <li><span style="color: #808000"><i class="fas fa-square"></i></span> 9:オリーブ系</li>
                      <li><span style="color: #0000FF"><i class="fas fa-square"></i></span> 10:ブルー系</li>
                      <li><span style="color: #000080"><i class="fas fa-square"></i></span> 11:ネイビー系</li>
                      <li><span style="color: #40E0D0"><i class="fas fa-square"></i></span> 12:ターコイズ系</li>
                      <li><span style="color: #E6E6FA"><i class="fas fa-square"></i></span> 13:ラベンダー系</li>
                      <li><span style="color: #800080"><i class="fas fa-square"></i></span> 14:パープル系</li>
                      <li><span style="color: #EE82EE"><i class="fas fa-square"></i></span> 15:バイオレット系</li>
                      <li><span style="color: #FF0000"><i class="fas fa-square"></i></span> 16:レッド系</li>
                      <li><span style="color: #FFC0CB"><i class="fas fa-square"></i></span> 17:ピンク系</li>
                      <li><span style="color: #FFA500"><i class="fas fa-square"></i></span> 18:オレンジ系</li>
                      <li><span style="color: #FFFF00"><i class="fas fa-square"></i></span> 19:イエロー系</li>
                      <li><span style="color: #FFD700"><i class="fas fa-square"></i></span> 20:ゴールド系</li>
                      <li><span style="color: #C0C0C0"><i class="fas fa-square"></i></span> 21:シルバー系</li>
                    </ul>
                  </td>
                  <td>@lang('csv.num')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('item.color_name')</th>
                  <td>color_name</td>
                  <td>カラーの名称を入力</td>
                  <td>@lang('csv.string')(30)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('item.size_name')</th>
                  <td>size_name</td>
                  <td>サイズの名称を入力。例：S、M、L、XL、F、38、40、24cm</td>
                  <td>@lang('csv.string')(10)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.item.desc')</th>
                  <td>@lang('csv.item.description')</td>
                  <td>@lang('csv.item.description_exp')</td>
                  <td>@lang('csv.string')(10000)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>サイズ詳細</th>
                  <td>size</td>
                  <td>商品サイズの詳細を入力してください。</td>
                  <td>@lang('csv.string')(10000)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.item.tag_code')</th>
                  <td>@lang('csv.item.tag')</td>
                  <td>@lang('csv.item.tag_exp')</td>
                  <td>@lang('csv.string')(100)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.item.group')</th>
                  <td>@lang('csv.item.group_code')</td>
                  <td>@lang('csv.item.group_code_exp')</td>
                  <td>@lang('csv.string')(40)</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.item.status')</th>
                  <td>@lang('csv.item.item_status')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.item.item_status_exp')</td>
                  <td>@lang('csv.item.status0')<br>@lang('csv.item.status1')</td>
                  <td></td>
                </tr>
                @if( $company->maker_flag == 1 )
                <tr>
                  <th>@lang('csv.item.g_flag')</th>
                  <td>@lang('csv.item.global_flag')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.item.global_flag_exp')</td>
                  <td>@lang('csv.bool_0')<br>@lang('csv.bool_1')</td>
                  <td></td>
                </tr>
                @elseif( $company->maker_flag == 0 )
                <tr>
                  <th>@lang('csv.item.g_flag')</th>
                  <td>@lang('csv.item.global_flag')</td>
                  <td><span class="text-danger">@lang('csv.required')</span><br>0を入力してください。</td>
                  <td>@lang('csv.bool_0')<br>@lang('csv.bool_1')</td>
                  <td></td>
                </tr>
                @endif
                <tr>
                  <th>@lang('csv.item.s_c_id')</th>
                  <td>@lang('csv.item.storemap_category_id')</td>
                  <td>@lang('csv.item.storemap_category_id_exp')<br>
                    <form method="get" action="{{ action('ItemCsvExportController@SMCTempFileDownload') }}" class="h-adr" enctype="multipart/form-data">
                      @csrf
                      @method('get')
                      <button type="submit" class="btn btn-warning"><i class="fas fa-file-download"></i> 一覧をダウンロード</button>
                    </form></td>
                  <td>@lang('csv.num')</td>
                  <td></td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img1')</th>
                  <td>@lang('csv.item.item_img1')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img2')</th>
                  <td>@lang('csv.item.item_img2')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img3')</th>
                  <td>@lang('csv.item.item_img3')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img4')</th>
                  <td>@lang('csv.item.item_img4')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img5')</th>
                  <td>@lang('csv.item.item_img5')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img6')</th>
                  <td>@lang('csv.item.item_img6')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img7')</th>
                  <td>@lang('csv.item.item_img7')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img8')</th>
                  <td>@lang('csv.item.item_img8')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img9')</th>
                  <td>@lang('csv.item.item_img9')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
                <tr>
                  <th>@lang('csv.item.img10')</th>
                  <td>@lang('csv.item.item_img10')</td>
                  <td>@lang('csv.item.item_img_exp')</td>
                  <td>@lang('csv.img')</td>
                  <td>@lang('csv.img_note')</td>
                </tr>
              </tbody>
            </table>
            <div class="mt-4 mb-5">
              <form method="get" action="{{ action('ItemCsvExportController@ItemTempFileDownload') }}" class="h-adr" enctype="multipart/form-data">
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