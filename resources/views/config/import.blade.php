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
                @if($api_token)
                <input id="api_copy" type="text" value="{{$api_token}}" readonly>
                <button id="copy" class="btn btn-success btn-sm"><i class="far fa-copy"></i> コピー</button>
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
              <p class="col-sm-4">在庫情報送信先URL</p>
              <p class="col-sm-8">https://storemap.jp/api/common/receive_stock</p>
              <p class="col-sm-4">商品情報送信先URL</p>
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
              <dd class="mb-4">
                <dl class="dl_second">
                  <dt> 1.1. HTTP メソッド</dt>
                  <dd>POSTを指定</dd>
                  <dt>1.2. ヘッダ情報</dt>
                  <dd>ヘッダ情報には下記の値を指定してください。
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
              <dd class="mb-4">ボディ情報にパラメータを設定し、リクエストしてください。<br>パラメータはJSON形式で設定してください。<br>
                パラメータの文字コードは「UTF-8」を指定してください。
                <dl class="dl_second">
                  <dt> 2.1. 在庫情報送信JSON形式</dt>
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
                          <td>更新名<br>※必須</td>
                          <td>在庫更新タイプはStockを指定
                          </td>
                        </tr>
                        <tr>
                          <td>data[stock_type]</td>
                          <td>在庫更新方法<br>※必須</td>
                          <td>0または1を指定<br>
                            0：絶対値で入力<br>
                            1：相対値で入力<br>
                            例：在庫数が100の商品に対し、<br>(0)を指定した場合stockAmountで50を入力すると、在庫数は50になります。<br>
                            (1)を指定した場合stockAmountで50を入力すると、在庫数は150になります。
                          </td>
                        </tr>
                        <tr>
                          <td>data[rows][$i]][storeId]</td>
                          <td>店舗コード<br>※必須</td>
                          <td>Storemapに登録済み店舗の店舗コードを指定</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][productId]</td>
                          <td>商品コード<br>※必須</td>
                          <td>Storemapに登録済みの商品コードを指定</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][stockAmount]</td>
                          <td>在庫数<br>※必須</td>
                          <td>在庫数を絶対値で指定</td>
                        </tr>
                      </tbody>
                    </table>
                  </dd>
                  <dt> 2.2. 在庫情報JSONサンプル</dt>
                  <dd>
                    便宜上、コメントや改行・空白を入れています
                    <pre class="bg-light disabled p-2">
{
&#009;"data": [{
&#009;&#009;"table_name": "Stock",
&#009;&#009;"stock_type": "0", // 絶対値または相対値かを指定
&#009;&#009;"rows": [{
&#009;&#009;&#009;"storeId": "T001", // 店舗コード
&#009;&#009;&#009;"productId": "ABCD123-BK-M", // 商品コード
&#009;&#009;&#009;"stockAmount": "5", // 在庫数を入力
&#009;&#009;&#009;},
&#009;&#009;&#009;{
&#009;&#009;&#009;"storeId": "T001", // 店舗コード
&#009;&#009;&#009;"productId": "EFGH456-PK-M", // 商品コード
&#009;&#009;&#009;"stockAmount": "3", // 在庫数を入力
&#009;&#009;&#009;},
&#009;&#009;&#009;{
&#009;&#009;&#009;"storeId": "T002", // 店舗コード
&#009;&#009;&#009;"productId": "EFGH456-PK-M", // 商品コード
&#009;&#009;&#009;"stockAmount": "4", // 在庫数を入力
&#009;&#009;&#009;}
&#009;&#009;]}
&#009;]
}</pre>
                  </dd>
                  <dt>2.3. 商品情報送信JSON形式</dt>
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
                          <td>Item<br>※必須</td>
                          <td>商品情報更新タイプはItemを指定
                          </td>
                        </tr>
                        <tr>
                          <td>data[rows][$i]][storeId]</td>
                          <td>店舗コード<br>※必須</td>
                          <td>Storemapに登録済み店舗の店舗コードを指定</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][productId]</td>
                          <td>商品コード(SKUコード)<br>※必須</td>
                          <td>Storemapに登録済みの商品コードを指定</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][price]</td>
                          <td>通常価格</td>
                          <td>店舗で販売するときの通常価格を指定<br>nullの場合は、基本情報の定価が反映されます<br>
                            項目が設定されていない場合は、以前のデータが引き継がれます。</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][value]</td>
                          <td>セール価格</td>
                          <td>店舗で販売するときのセール価格を指定<br>nullの場合は、既存の値が削除されます<br>※セール価格は通常価格よりも低い値を指定してください<br>
                            項目が設定されていない場合は、以前のデータが引き継がれます。</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][startDate]</td>
                          <td>開始日時</td>
                          <td>セール開始日時を指定<br>YYYY-mm-dd HH:MM:SS形式<br>nullの場合は、既存の値が削除されます<br>
                            項目が設定されていない場合は、以前のデータが引き継がれます。</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][endDate]</td>
                          <td>終了日時<</td>
                          <td>セール終了日時を指定<br>YYYY-mm-dd HH:MM:SS形式<br>nullの場合は、既存の値が削除されます<br>※セール終了日時はセール開始日時よりも、後の日時を指定してください。<br>
                            項目が設定されていない場合は、以前のデータが引き継がれます。</td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][shelf_number]</td>
                          <td>棚番号</td>
                          <td>商品を陳列している棚番号を指定<br>
                            項目が設定されていない場合は、以前のデータが引き継がれます。
                          </td>
                        </tr>
                        <tr>
                          <td>data[rows][$i][displayFlag]</td>
                          <td>表示設定</td>
                          <td>商品の表示、非表示をbooleanで指定<br>
                            0:非表示<br>
                            1:表示<br>
                            項目が設定されていない場合は、以前のデータが引き継がれます。
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </dd>
                  <dt> 2.4. 商品情報JSONサンプル</dt>
                  <dd>
                    便宜上、コメントや改行・空白を入れています
                    <pre class="bg-light disabled p-2">
{
&#009;"data": [{
&#009;&#009;"table_name": "Item",
&#009;&#009;"rows": [{
&#009;&#009;&#009;"storeId": "T001", // 店舗コード
&#009;&#009;&#009;"productId": "ABCD123-BK-M", // 商品コード
&#009;&#009;&#009;"price": "10000", // 通常価格を指定
&#009;&#009;&#009;"value": "5000", // セール価格を指定
&#009;&#009;&#009;"startDate": "2021-12-31 00:00:00", // セール開始日時を指定
&#009;&#009;&#009;"endDate": "2022-01-01 01:59:59", // セール終了日時を指定
&#009;&#009;&#009;"shelf_number": "A-123", // 半角英数記号
&#009;&#009;&#009;"displayFlag": "1", // 0か1を指定
&#009;&#009;&#009;},
&#009;&#009;&#009;{
&#009;&#009;&#009;"storeId": "T001", // 店舗コード
&#009;&#009;&#009;"productId": "EFGH456-PK-M", // 商品コード
&#009;&#009;&#009;"price": "10000", // 通常価格を指定
&#009;&#009;&#009;"value": "", // セール価格を指定
&#009;&#009;&#009;"startDate": "", // セール開始日時を指定
&#009;&#009;&#009;"endDate": "", // セール終了日時を指定
&#009;&#009;&#009;"shelf_number": "", // 半角英数記号
&#009;&#009;&#009;"displayFlag": "0", // 0か1を指定
&#009;&#009;&#009;},
&#009;&#009;&#009;{
&#009;&#009;&#009;"storeId": "T002", // 店舗コード
&#009;&#009;&#009;"productId": "EFGH456-PK-M", // 商品コード
&#009;&#009;&#009;"shelf_number": "A-253", // 半角英数記号
&#009;&#009;&#009;}
&#009;&#009;]}
&#009;]
}</pre>
                  </dd>
                </dl>

              </dd>
              <dt>3. レスポンス</dt>
              <dd>サーバーからのPOST応答に関する各HTTPレスポンスステータスコードの動作例は下記となります。
                <dl class="dl_second">
                  <dt></dt>
                  <dd>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>ステータスコード</th>
                          <th>説明</th>
                          <th>状態</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>200</td>
                          <td>リクエストが正常に処理できた</td>
                          <td>正常
                          </td>
                        </tr>
                        <tr>
                          <td>400 data not found</td>
                          <td>データが見つからない</td>
                          <td>エラー</td>
                        </tr>
                        <tr>
                          <td>400 Company not found</td>
                          <td>適合する会社が見つからない。契約ID又はアクセストークンに誤りがあるか、登録されている会社がない</td>
                          <td>エラー</td>
                        </tr>
                        <tr>
                          <td>400 table_name not found</td>
                          <td>table_nameが見つからない</td>
                          <td>エラー</td>
                        </tr>
                        <tr>
                          <td>400 Incorrect specification of table_name</td>
                          <td>table_nameの指定に誤りがある、又は見つからない</td>
                          <td>エラー</td>
                        </tr>
                        <tr>
                          <td>400 productId not found</td>
                          <td>JSONデータに商品コードの指定が見つからない</td>
                          <td>エラー</td>
                        </tr>
                        <tr>
                          <td>400 storeId not found</td>
                          <td>JSONデータに店舗コードの指定が見つからない</td>
                          <td>エラー</td>
                        </tr>
                        <tr>
                          <td>403 Access denied</td>
                          <td>アクセス権限がない。apiの利用が許可されていない</td>
                          <td>エラー</td>
                        </tr>
                      </tbody>
                    </table>
                  </dd>
                </dl>
              </dd>
              <dt>4. 登録の失敗</dt>
              <dd>店舗コード及び、商品コードが見つかりリクエストを送信することに成功したが、バリデーション時にエラーが発生した場合は、会社情報に登録されている連絡用メールアドレスにエラー内容が送信されます。<br>例：日時の書式設定に誤りがある場合等。<br>
              バリデーションにエラーが発生した商品、データは登録されませんが、同時に送られたバリデーションに合格したデータは、そのまま登録されます。
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
    margin-top: 1rem;
  }

  dd {
    margin-bottom: 1rem;
  }

  #api_copy {
    width: 35%;
    border: none;
  }
</style>
@stop

@section('js')
<script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init()
  })

  function copy() {
    var copyText = document.querySelector("#api_copy");
    copyText.select();
    document.execCommand("copy");
  }

  document.querySelector("#copy").addEventListener("click", copy);
</script>
@stop