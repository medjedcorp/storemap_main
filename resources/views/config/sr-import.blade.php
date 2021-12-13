@extends('adminlte::page')

@section('title', 'Storemap Cockpit：スマレジAPI連携設定')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">スマレジAPI連携設定</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">スマレジAPI連携設定</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
@include('partials.danger')
@include('partials.success')
<section class="content">
  <div id="wrap" class="container-fluid">
    <div class="row">
      <div class="col-6">
        <div class="card card-outline card-primary">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-compress-alt"></i>
              商品取込用スマレジID設定
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
                <label for="ext_token" class="col-sm-3 col-form-label">スマレジアクセストークン</label>
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
          </div><!-- /.card-body -->

        </div>
      </div>

      <div class="col-6">
        <div class="card card-outline card-primary">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-cloud-download-alt"></i>
              取込品番設定(個別)
            </h3>
          </div>
          <div class="card-body">
            <form id="productImport" method="post" action="{{route('sr.productStore')}}" enctype="multipart/form-data" class="d-block">
              @csrf
              @method('POST')
              <input type="hidden" name="product" form="productImport" value="true">
              <input type="hidden" name="ext_id" form="productImport" value="{{$ext_id}}">
              <input type="hidden" name="ext_token" form="productImport" value="{{$ext_token}}">
              <div class="form-group">
                @if($errors->has('pcoderadio') || count($errors) > 0)
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" form="productImport" type="radio" id="pcodeRadio0" name="pcoderadio" value="0" {{ old('pcoderadio', old('pcoderadio')) === '0' ? 'checked' : ''}}>
                  <label for="pcodeRadio0" class="custom-control-label">登録 <small style="font-weight:normal;">※登録済みの商品は更新されません</small></label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" form="productImport" type="radio" id="pcodeRadio1" name="pcoderadio" value="1" {{ old('pcoderadio', old('pcoderadio'))=== '1' ? 'checked' : ''}}>
                  <label for="pcodeRadio1" class="custom-control-label">更新 <small style="font-weight:normal;">※登録済みの商品も更新されます</small></label>
                </div>
                @else
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" form="productImport" type="radio" id="pcodeRadio0" name="pcoderadio" value="0" checked>
                  <label for="pcodeRadio0" class="custom-control-label">登録 <small style="font-weight:normal;">※登録済みの商品は変更されません</small></label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" form="productImport" type="radio" id="pcodeRadio1" name="pcoderadio" value="1">
                  <label for="pcodeRadio1" class="custom-control-label">更新 <small style="font-weight:normal;">※登録済みの商品も変更されます</small></label>
                </div>
                @endif
                @if($errors->has('pcoderadio'))
                <span id="pcoderadio-error" class="error text-danger">{{$errors->first('pcoderadio')}}</span>
                @endif
              </div>
              <div class="form-group">
                <label>JANコード</label>

                @if($errors->has('jancode'))
                <textarea id="jancode" class="form-control is-invalid" name="jancode" rows="3" aria-describedby="jancode-error" aria-invalid="true" placeholder="スマレジに登録済みの、取り込みたい商品のJANコードを改行して入力してください。一度に取り込める商品数は１００点までになります。">{{old('jancode', isset($jancode) ? $jancode : '') }}</textarea>
                <span id="jancode-error" class="error invalid-feedback">{{$errors->first('jancode')}}</span>
                @else
                <textarea id="jancode" class="form-control" name="jancode" rows="3" placeholder="スマレジに登録済みの、取り込みたい商品のJANコードを改行して入力してください。一度に取り込める商品数は１００点までになります。"></textarea>
                @endif

              </div>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>
                商品データを取得する</button>
            </form>
          </div><!-- /.card-body -->
        </div>
      </div>

      <div class="col-12">
        <div class="card card-outline card-primary">
          <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
              <i class="fas fa-cloud-download-alt"></i>
              取込品番設定(全商品)
            </h3>
          </div>
          <div class="card-body">
            <form id="productAllImport" method="post" action="{{route('sr.productAllStore')}}" enctype="multipart/form-data" class="d-block" name="productAllImport">
              @csrf
              @method('POST')
              <input type="hidden" name="product" form="productAllImport" value="true">
              <input type="hidden" name="ext_id" form="productAllImport" value="{{$ext_id}}">
              <input type="hidden" name="ext_token" form="productAllImport" value="{{$ext_token}}">
              <div class="form-group">
                @if($errors->has('allradio') || count($errors) > 0)
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" form="productAllImport" type="radio" id="allRadio0" name="allradio" value="0" {{ old('allradio', old('allradio')) === '0' ? 'checked' : ''}}>
                  <label for="allRadio0" class="custom-control-label">登録 <small style="font-weight:normal;">※登録済みの商品は更新されません</small></label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" form="productAllImport" type="radio" id="AllRadio1" name="allradio" value="1" {{ old('allradio', old('allradio'))=== '1' ? 'checked' : ''}}>
                  <label for="AllRadio1" class="custom-control-label">更新 <small style="font-weight:normal;">※登録済みの商品も更新されます</small></label>
                </div>
                @else
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" form="productAllImport" type="radio" id="allRadio0" name="allradio" value="0" checked>
                  <label for="allRadio0" class="custom-control-label">登録 <small style="font-weight:normal;">※登録済みの商品は変更されません</small></label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" form="productAllImport" type="radio" id="AllRadio1" name="allradio" value="1">
                  <label for="AllRadio1" class="custom-control-label">更新 <small style="font-weight:normal;">※登録済みの商品も変更されます</small></label>
                </div>
                @endif
                @if($errors->has('allradio'))
                <span id="allradio-error" class="error text-danger">{{$errors->first('allradio')}}</span>
                @endif
              </div>
              <button type="submit" class="btn btn-primary" id="btnFetch"><i class="fa fa-check-square"></i>
                全ての商品データを取得する</button>
            </form>
          </div><!-- /.card-body -->
        </div>
      </div>


      <div class="col-12">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-download"></i> 登録について</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <dl class="paragraph-1">
              <dt>1.連携設定</dt>
              <dd>スマレジAPIから商品情報を取得するために、スマレジの契約IDとアクセストークンが必要になります。スマレジの管理画面、[設定 ＞ システム連携 ＞ スマレジAPI設定]と進んでください。
              </dd>
              <dt>2.アクセストークンの作成</dt>
              <dd>
                アクセストークン欄の「アクセストークン発行」をクリックします。
                <div><img src="{{asset('img/smareji/smapi1.gif')}}" style="max-width:100%;"></div>
              </dd>

              <dt>3.契約IDとアクセストークンの値をストアマップ上の、「商品取込用スマレジID設定」欄に入力します。</dt>
              <dd>
                アクセストークン欄の「アクセストークン発行」をクリックします。
                <ul>
                  <li>スマレジ契約ID欄に、契約IDの値を入力してください。</li>
                  <li>スマレジアクセストークン欄に、アクセストークンの値を入力してください。</li>
                  <li>入力が終わったら、スマレジAPIの情報を更新ボタンを押してください。</li>
                </ul>
                <div><img src="{{asset('img/smareji/smapi3.gif')}}" style="max-width:100%;"></div>
              </dd>
              <dt>4.スマレジ側設定</dt>
              <dd>
                スマレジAPI設定画面の下部にスクロールします。「13商品情報参照」が「利用する」になっていることを確認してください。
                利用するに変更した場合は、最下部までスクロールして更新ボタンをクリックしてください。
                <div><img src="{{asset('img/smareji/smapi2.gif')}}" style="max-width:100%;"></div>
              </dd>
              <dt>5.商品データの取込(個別：品番指定)</dt>
              <dd>
                取込品番設定(個別)欄に取り込みたいJANコードの値を改行して入力してください。
                <ul>
                  <li>登録を押すと、登録のない商品が全て取得して登録されます。既存データは更新されません。</li>
                  <li>更新を押すと、登録済みの商品も含めて全ての商品データを取得して登録されます。既存データも更新されます。</li>
                  <li>入力が終わったら、商品データを取得するをクリックしてください。</li>
                </ul>
                <div><img src="{{asset('img/smareji/smapi4.gif')}}" style="max-width:100%;"></div>
              </dd>
              <dt>6.商品データの取込(全商品)</dt>
              <dd>
                スマレジに登録済みの商品データ全てを取得することができます。
                <ul>
                  <li>登録を押すと、登録のない商品が全て取得して登録されます。既存データは更新されません。</li>
                  <li>更新を押すと、登録済みの商品も含めて全ての商品データを取得して登録されます。既存データも更新されます。</li>
                  <li>入力が終わったら、商品データを取得するをクリックしてください。</li>
                </ul>
                <div><img src="{{asset('img/smareji/smapi5.gif')}}" style="max-width:100%;"></div>
              </dd>
            </dl>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
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
<style>
  .paragraph-1 dd {
    margin-bottom: 1.5rem;
  }

  .paragraph-2 {
    margin-top: .5rem;
    margin-left: 1rem;
  }

  .paragraph-2 dd {
    margin-bottom: 1.5rem;
  }
</style>
<style>

</style>
@stop

@section('js')
<script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function() {
    bsCustomFileInput.init()
  })
</script>

<script>
  $(document).ready(function() {
    $("#btnFetch").click(function() {
      // disable button
      $(this).prop("disabled", true);
      // add spinner to button
      $(this).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...しばらくお待ちください`
      );
      $("form").submit();
    });
  });
</script>
@stop