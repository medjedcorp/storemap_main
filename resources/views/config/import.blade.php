@extends('adminlte::page')

@section('title', 'Storemap Cockpit：受信用API設定')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">受信用API設定</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">受信用API設定</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-outline card-primary">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-handshake mr-1"></i>
              受信設定
            </h3>
          </div>

          @include('partials.success')
          @include('partials.danger')

          <div class="card-body">
            <div class="row">
              <p class="col-sm-4">契約ID</p>
              <p class="col-sm-8">{{$company_code}}</p>
              <p class="col-sm-4">アクセストークン</p>
              <div class="col-sm-8">
                @if($api_token) {{$api_token}}
                <form id="generate_form" method="POST" action="{{route('sm.apiDel')}}" enctype="multipart/form-data" class="d-inline-block ml-2">
                  @csrf
                  @method('POST')
                  <button form="generate_form" type="submit" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i> アクセストークン削除</button>
                </form>
                @else
                <form id="generate_form" method="POST" action="{{route('sm.generate')}}" enctype="multipart/form-data" class="d-inline-block">
                  @csrf
                  @method('POST')
                  <button form="generate_form" type="submit" class="btn btn-info"><i class="fas fa-key"></i> アクセストークン作成</button>
                </form>
                @endif
              </div>
              <p class="col-sm-4">在庫設定受信用URL</p>
              <p class="col-sm-8">https://storemap.jp/api/common/receive_stock</p>
              <p class="col-sm-4">価格設定受信用URL</p>
              <p class="col-sm-8">https://storemap.jp/api/common/receive_item</p>
              <div class="col-12">
                <form id="flag_form" method="POST" action="{{route('sm.useApi')}}" enctype="multipart/form-data" class="row">
                  @csrf
                  @method('POST')
                  <div class="col-sm-4">受信機能を利用する</div>
                  <div class="col-sm-8">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label class="btn btn-outline-info active">
                        <input form="flag_form" type="radio" name="api_flag" id="api_flag0" value="0" {{ old('api_flg' , $api_flag ) == '0' ? 'checked' : '' }}>利用しない </label>
                      <label class="btn btn-outline-info">
                        <input form="flag_form" type="radio" name="api_flag" id="api_flag1" value="1" {{ old('api_flg' , $api_flag ) == '1' ? 'checked' : '' }}>利用する </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i> 更新</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!-- /.card-body -->
      </div>
      <div class="col-12">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-download"></i> 受信用APIの設定について</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <h2>外部連携API共通仕様</h2>
            <hr>
            <dl class="dl_first">
              <dt>1.リクエスト</dt>
              <dd class="mb-2">
                <dl class="dl_second">
                  <dt> 1.1. HTTP メソッド</dt>
                  <dd>POSTを指定</dd>
                  <dt>1.2. ヘッダ情報</dt>
                  <dd>ヘッダ情報には下記の値を指定してください
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>キー</th>
                          <th>設定値</th>
                          <th>備考</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Content-Type</td>
                          <td>application/json; charset=utf-8</td>
                          <td>json形式、文字コードはUTF-8を指定
                          </td>
                        </tr>
                        <tr>
                          <td>X-contract-id</td>
                          <td>契約IDを記入</td>
                          <td>受信設定にある契約IDを入力してください</td>
                        </tr>
                        <tr>
                          <td>X-access-token</td>
                          <td>アクセストークンを記入</td>
                          <td>受信設定にあるアクセストークンを入力してください</td>
                        </tr>
                      </tbody>
                    </table>

                  </dd>
                </dl>
              </dd>
              <dt>2.ボディ情報</dt>
              <dd>ボディ情報にパラメータを設定し、リクエストしてください。<br>パラメータはJSON形式で設定する。<br>
                その際のパラメータは文字コードを「UTF-8」を指定してください。
                <dl class="dl_second">
                  <dt> 2.1. 在庫設定用JSON形式</dt>
                  <dd>基本フォーマットは以下のとおりです。
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>キー</th>
                          <th>設定値</th>
                          <th>備考</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>data[table_name]</td>
                          <td>Stock</td>
                          <td>在庫更新タイプはStockを指定
                          </td>
                        </tr>
                        <tr>
                          <td>data[rows][$i]][storeId]</td>
                          <td>店舗コード</td>
                          <td>Storemapに登録済み店舗の店舗コードを指定</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][productId]</td>
                          <td>商品コード</td>
                          <td>Storemapに登録済みの商品コードを指定</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][stockAmount]</td>
                          <td>在庫数</td>
                          <td>在庫数を絶対値で指定</td>
                        </tr>
                      </tbody>
                    </table>  
                  </dd>
                  <dt> 2.2. 在庫設定JSONサンプル</dt>
                  <dd>
                    便宜上、コメントや改行・空白を入れています
                    <pre class="bg-light disabled p-2">
{
&#009;"data": [{
&#009;&#009;"table_name": "Stock",
&#009;&#009;"rows": [{
&#009;&#009;&#009;"storeId": "T001", // 店舗コード
&#009;&#009;&#009;"productId": "ABCD123-BK-M", // 商品コード
&#009;&#009;&#009;"stockAmount": "5", // 在庫数を絶対値で指定
&#009;&#009;&#009;},
&#009;&#009;&#009;{
&#009;&#009;&#009;"storeId": "T001", // 店舗コード
&#009;&#009;&#009;"productId": "EFGH456-PK-M", // 商品コード
&#009;&#009;&#009;"stockAmount": "3", // 在庫数を絶対値で指定
&#009;&#009;&#009;},
&#009;&#009;&#009;{
&#009;&#009;&#009;"storeId": "T002", // 店舗コード
&#009;&#009;&#009;"productId": "EFGH456-PK-M", // 商品コード
&#009;&#009;&#009;"stockAmount": "4", // 在庫数を絶対値で指定
&#009;&#009;&#009;}
&#009;&#009;]}
&#009;]
}</pre>
                  </dd>
                  <dt>1.2. ヘッダ情報</dt>
                  <dd>ヘッダ情報には下記の値を指定してください


                  </dd>
                </dl>

              </dd>
              <dd>Donec id elit non mi porta gravida at eget metus.</dd>
              <dt>Malesuada porta</dt>
              <dd>Etiam porta sem malesuada magna mollis euismod.</dd>
            </dl>





          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>
@stop

@section('right-sidebar')
<div class="os-padding text-sm">
  <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
    <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">

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
<style>
  .dl_second {
    margin-left: 1rem;
  }

  dd {
    margin-bottom: 1rem;
  }
</style>
@stop

@section('js')
<script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init()
  })
</script>
@stop