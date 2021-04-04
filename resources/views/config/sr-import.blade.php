@extends('adminlte::page')

@section('title', 'Storemap Cockpit：スマレジAPI連携設定')

@section('content_header')
<h1>スマレジAPI連携設定</h1>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-handshake mr-1"></i>
              商品連携ID設定
            </h3>
          </div>
          <div class="card-body">
            <form id="srTokenSave" method="POST" action="{{route('sr.tokensave')}}" enctype="multipart/form-data" class="d-block">
              @csrf
              @method('POST')
              <div class="form-group row">
                <label for="ext_id" class="col-sm-3 col-form-label">スマレジ契約ID</label>
                <div class="col-sm-9">
                  @if($errors->has('ext_id'))
                  <input form="srTokenSave" type="text" class="form-control is-invalid" name="ext_id" id="ext_id" placeholder="スマレジ契約IDを入力してください" value="{{old('ext_id', isset($ext_id) ? $ext_id : '') }}" aria-describedby="ext_id-error" aria-invalid="true">
                  <span id="ext_id-error" class="error invalid-feedback">{{$errors->first('ext_id')}}</span>
                  @else
                  <input form="srTokenSave" type="text" class="form-control" id="ext_id" name="ext_id" placeholder="スマレジ契約IDを入力してください" value="{{old('ext_id', isset($ext_id) ? $ext_id : '') }}">
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <label for="ext_token" class="col-sm-3 col-form-label">アクセストークン</label>
                <div class="col-sm-9">
                  @if($errors->has('ext_token'))
                  <input form="srTokenSave" type="text" class="form-control is-invalid" name="ext_token" id="ext_token" placeholder="スマレジAPIのアクセストークンを入力してください" value="{{old('ext_token', isset($ext_token) ? $ext_token : '') }}" aria-describedby="ext_token-error" aria-invalid="true">
                  <span id="ext_token-error" class="error invalid-feedback">{{$errors->first('ext_token')}}</span>
                  @else
                  <input form="srTokenSave" type="text" class="form-control" id="ext_token" name="ext_token" placeholder="スマレジAPIのアクセストークンを入力してください" value="{{old('ext_token', isset($ext_token) ? $ext_token : '') }}">
                  @endif
                </div>
              </div>

              <button form="srTokenSave" type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>
                @if(isset($ext_id) and isset($ext_token))
                スマレジAPIの情報を更新
                @else
                スマレジAPIの情報を登録
                @endif
              </button>
            </form>

            {{-- @if(isset($contract_id) and isset($access_token))
            <hr>
            <form id="productRef" method="get" action="{{route('sr.product_ref')}}" enctype="multipart/form-data" class="d-block">
            @csrf
            @method('get')
            <input type="hidden" name="product" form="productRef" value="true">
            <input type="hidden" name="contract_id" form="productRef" value="{{$contract_id}}">
            <input type="hidden" name="access_token" form="productRef" value="{{$access_token}}">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>
              商品データを取得する</button>
            </form>
            @endif --}}

            {{-- @isset($productLists)
            <hr>
            <form id="productUpdate" method="get" action="{{route('sr.product_update')}}" enctype="multipart/form-data" class="d-block">
            @csrf
            @method('get')
            <input type="hidden" name="productUpdate" form="productUpdate" value="{{$productLists}}">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>
              商品情報を更新する</button>
            </form>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>スマレジID</th>
                  <th>JAN</th>
                  <th>商品名</th>
                  <th>定価</th>
                </tr>
              </thead>
              <tbody>
                @foreach($productLists as $productList => $product)
                <tr>
                  <td>{{$product->productId}}</td>
                  <td>{{$product->productCode}}</td>
                  <td>{{$product->productName}}</td>
                  <td>{{$product->price}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @endisset --}}

          </div><!-- /.card-body -->

        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-handshake mr-1"></i>
              店舗連携設定
            </h3>
          </div>
          <div class="card-body">
            <div class="row">
              <p class="col-sm-8">店舗名</p>
              <p class="col-sm-4">スマレジ店舗ID</p>
            </div>
            <form id="srIdSave" method="POST" action="{{route('sr.storeSave')}}" enctype="multipart/form-data" class="d-block">
              @csrf
              @method('POST')
              @foreach($stores as $store)
              <div class="form-group row">
                <label for="ext_store_code{{$store->id}}" class="col-sm-8 col-form-label">
                  <input form="srIdSave" type="hidden" class="form-control" name="store_id[]" value="{{$store->id}}">{{$store->store_name}}</label>
                <div class="col-sm-4">
                  <input form="srIdSave" type="text" class="form-control" id="ext_store_code{{$store->id}}" name="ext_store_code[]" placeholder="スマレジの店舗IDを入力してください" value="{{old('ext_store_code.[]', isset($store->ext_store_code) ? $store->ext_store_code : '') }}">
                </div>
              </div>
              {{-- <div class="form-group row">
                <label for="srIdSave" class="col-sm-8 col-form-label">
                  <input form="srIdSave" type="hidden" class="form-control" name="store_id[]" value="{{$store->id}}">{{$store->store_name}}</label>
              <div class="col-sm-9"> --}}
                {{-- @if($errors->has('ext_store_code')) --}}
                {{-- @if($errors->has('ext_store_code.[]'))
                  <input form="srIdSave" type="text" class="form-control is-invalid" name="ext_store_code[]" id="ext_store_code{{$store->id}}" placeholder="スマレジの店舗IDを入力してください" value="{{old('ext_store_code.[]', isset($store->ext_store_code) ? $store->ext_store_code : '') }}" aria-describedby="ext_store_code{{$store->id}}-error" aria-invalid="true">
                <span id="ext_store_code{{$store->id}}-error" class="error invalid-feedback">{{$errors->first('ext_store_code')}}</span>
                @else
                <input form="srIdSave" type="text" class="form-control" id="ext_store_code{{$store->id}}" name="ext_store_code[]" placeholder="スマレジの店舗IDを入力してください" value="{{old('ext_store_code.[]', isset($store->ext_store_code) ? $store->ext_store_code : '') }}">
                @endif
              </div>
          </div> --}}
          @endforeach
          <button form="srIdSave" type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>
            スマレジ店舗IDを更新
          </button>
          </form>

          @if($errors->has('ext_store_code.*'))
              <ul>
                @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
                @endforeach
              </ul>
          @endif

        </div><!-- /.card-body -->
      </div>
    </div>
  </div>
  <!-- /.nav-tabs-custom -->
  <div class="row">
    <div class="col-lg-6">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fa fa-upload mr-1"></i>
            商品連携用CSVのアップロード
          </h3>
        </div>
        @include('partials.danger')
        @include('partials.success')
        <!-- /.card-header -->
        <div class="card-body">
          <p><strong>スマレジと価格及び在庫数の連携が可能です。</strong>
            <br>・スマレジの商品IDを、ストアマップの外部商品ID(ext_product_code)に登録する必要があります
            <br>・ストアマップの商品コード、外部商品ID(ext_product_code)を入力したcsvをアップロードしてください。
            <br>@lang('csv.upload_size')</p>

          <form id="importCSV" method="post" action="{{route('sr.importCSV')}}" class="h-adr" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="custom-file">
              <input form="importCSV" type="file" class="custom-file-input" id="file" name="file">
              <label class="custom-file-label" for="file">ファイルを選択</label>
            </div>
            <small id="fileHelp" class="form-text text-muted mb-2">@lang('category.data.upload_small')</small>
            <br>
            <button form="importCSV" type="submit" class="btn btn-block btn-primary btn-lg"><i class="fa fa-upload"></i> @lang('csv.upload')</button>
          </form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <div class="col-lg-6">
      <div class="card card-outline card-info">
        <div class="card-header">
          <h3 class="card-title"><i class="fa fa-download"></i> 登録用テンプレートファイル</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <p>商品連携用CSVのテンプレートファイルをダウンロードできます。</p>
          <form id="downloadCSV" method="get" action="{{ action('SmaregiController@SmarejiTempFileDownload') }}" class="h-adr" enctype="multipart/form-data">
            @csrf
            @method('get')
            <button form="downloadCSV" type="submit" class="btn btn-warning"><i class="fas fa-file-download"></i> @lang('csv.template')</button>
          </form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <div class="col-12">
      <div class="card card-outline card-info">
        <div class="card-header">
          <h3 class="card-title"><i class="fa fa-download"></i> 登録について</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <img src="{{asset('img/smareji/smareji_setteing1.gif')}}">
          <img src="{{asset('img/smareji/smareji_setteing2.gif')}}">
          <img src="{{asset('img/smareji/smareji_setteing3.gif')}}">
          <img src="{{asset('img/smareji/smareji_setteing4.gif')}}">
          <img src="{{asset('img/smareji/smareji_setteing5.gif')}}">
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
  {{-- <div class="card card-outline card-primary">
              <!-- /.card-header -->
              <div class="card-body">
                 <form method="post" action="{{ route('cate.importCateCSV') }}" class="h-adr" enctype="multipart/form-data">
  @csrf
  @method('post')
  <div class="custom-file">
    <input type="file" class="custom-file-input" id="file" name="file">
    <label class="custom-file-label" for="file">@lang('category.data.upload_label')</label>
  </div>
  <small id="fileHelp" class="form-text text-muted mb-2">@lang('category.data.upload_small')</small>
  <br>
  <button type="submit" class="btn btn-block btn-primary btn-lg"><i class="fa fa-upload"></i> @lang('csv.upload')</button>
  </form>
  </div>
  <!-- /.card-body -->
  </div> --}}


  {{-- </div><!-- /.card-body -->

        </div> --}}
  <!-- /.nav-tabs-custom -->
  </div>
</section>
@stop

@section('right-sidebar')
<div class="os-padding text-sm">
  <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
    <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">
      <h5>スマレジ連携について</h5>
      <hr class="mb-2">
      <p class="mb-5">スマレジ連携設定をすることで、在庫情報、価格情報、商品の表示設定を連携することが可能です。連携することで、スマレジを更新した場合、自動でストアマップ上のデータが更新されます。</p>
      <h6>商品連携ID設定</h6>
      <p class="mb-5">[スマレジ管理画面＞システム連携＞スマレジAPI設定]より、API受信設定にある「契約ID」と「アクセストークン」の値を、ストアマップ上の当画面内「スマレジ契約ID」、「アクセストークン」欄にコピーしてください。</p>
      <h6>店舗連携設定</h6>
      <p class="mb-5">[スマレジ管理画面＞店舗＞店舗一覧]より、店舗IDの値を、ストアマップ上の当画面内[店舗連携設定]にある「スマレジ店舗ID」欄にコピーしてください。</p>
      <h6>商品連携設定</h6>
      <p class="mb-5">スマレジに登録されている商品と、ストアマップに登録されている商品を紐づける必要があります。登録用テンプレートファイルをダウンロードして、「product_code」にストアマップ上に登録した商品コードを入力してください。「ext_product_code」には対応したスマレジ側の商品IDを入力してください。</p>
      <h6>商品情報送信設定</h6>
      <p class="mb-5">スマレジ側に商品情報を送信する設定をします。[スマレジ管理画面＞システム連携＞スマレジAPI設定]画面より、API送信設定のタブを選びます。「商品情報送信」と「在庫情報送信」の利用するにチェックを入れます。個別設定を押し設定画面を開きます。「商品情報送信」の送信URLに【https://storemap.jp/api/sregi/receive_item】を入力、「在庫情報送信」の送信URLに【https://storemap.jp/api/sregi/receive_stock】を入力します。両方のヘッダ情報欄の追加を２回押します。１行目に[id]=[契約ID]と、２行目に[token]=[アクセストークン]となるように値を入力してください。</p>
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
<script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init()
  })
</script>
@stop